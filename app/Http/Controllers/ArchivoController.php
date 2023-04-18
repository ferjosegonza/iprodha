<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iprodha\Vw_dig_parabuscararchivo;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_subtipoarchivo;
use DB;


class ArchivoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }


    public function consultar(){
        $boletin = DB::table('iprodha.Vw_dig_parabuscararchivo')->max('fecha_boletin');
        $archivos = Vw_dig_parabuscararchivo::where('id_tipocabecera', '=', 1)->where('fecha_boletin', '=', $boletin)->orderBy('nombre_corto', 'asc')->orderBy('ano_archivo', 'desc')->orderBy('mes_archivo', 'desc')->orderBy('dia_archivo', 'desc')->get();
       foreach($archivos as $a){
            $a->path_archivo = substr($a->path_archivo, 14);
        } 
        $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
        $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
        
        return view('archivo.index')
            ->with('TipoDocumento',$TipoDocumento)
            ->with('SubTipoDocumento',$SubTipoDocumento)
            ->with('archivos',$archivos);
    }

public function buscar(Request $request){
    //return $request;
    $tipo= explode('|',$request->tipo);
    if($request->tipo != 'sel')
    {
        $nomtipo=$tipo[1];
        $tipo = $tipo[0];
    }
    $subtipo = explode('|', $request->subtipo);
    if($request->subtipo != 'sel'){
        $subtipo = $subtipo[2];
    }    
    $busqueda = strtoupper($request->busqueda);
    $fecha1=$request->fecha1;
    $fecha2=$request->fecha2;

    if($request->betwenyears == 'on'){
        //checkbox on    
        if($fecha1 != null and $fecha2 != null){
            //hay un rango de fechas
            if($tipo !=['sel']){
                //se eligio un tipo
                    if($subtipo != ['sel']){
                        //se eligio un subtipo
                        if($busqueda != null)
                        {
                            //hay una busqueda            
                            $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                            WHERE id_tipocabecera = 1 AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')
                            AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'  AND id_subtipoarchivo = '$subtipo' 
                            AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                            order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));            
                        }
                        else
                        {
                                //no hay una busqueda
                                $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                                WHERE id_tipocabecera =1 AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')
                                AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo'
                                order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                            WHERE id_tipocabecera =1 AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')
                            AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' 
                            AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                            order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                        }
                        else
                        {
                            //no hay busqueda
                            $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                            WHERE id_tipocabecera =1 AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')
                            AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'
                            order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                        }
                    }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                    WHERE id_tipocabecera =1 AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')
                    AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                    order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                }                                
            }
        }            
        else if($fecha1 != null and $fecha2 == null){
            //hay una fecha minima
            if($tipo !=['sel']){
                //se eligio un tipo
                if($subtipo != ['sel']){
                    //se eligio un subtipo
                    if($busqueda != null){
                        //hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo between >= to_date('$fecha1', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                    else{
                        //no hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo between >= to_date('$fecha1', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo'
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
                else{
                    //no hay subtipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo between >= to_date('$fecha1', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'  
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                    else{
                        //no hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo between >= to_date('$fecha1', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo between >= to_date('$fecha1', 'YYYY-MM-DD')
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                }
            }
        }
        else if($fecha1 == null and $fecha2 != null){
            //Hay una fecha maxima
            if($tipo !=['sel']){
                //se eligio un tipo
                if($subtipo != ['sel']){
                    //se eligio un subtipo
                    if($busqueda != null){
                        //hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));                                                      
                    }
                    else{
                        //no hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));      
                    }
                }
                else{
                    //no hay subtipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));         
                    }
                    else{
                        //no hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' 
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));      
                    }
                }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));      
                }                   
            }
        }            
        else{
            //no se eligio fecha
            if($tipo !=['sel']){
                //se eligio un tipo
                if($subtipo != ['sel']){
                    //se eligio un subtipo
                    if($busqueda != null){
                        //hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
                else{
                    //no hay subtipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                        order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                    WHERE id_tipocabecera =1 
                    AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')
                    order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                }
            }
        }            
    }
    else{
        $año = $request->ano;
        if($año != 'sel'){
            if($tipo != ['sel']){
                //se eligio un tipo
                if($subtipo != ['sel']){
                    //se eligio un subtipo
                    if($busqueda != null){
                        //hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND ano_archivo = '$año' 
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                    else{
                        //no hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND ano_archivo = '$año'
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo'order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
                else{
                    //no hay subtipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND ano_archivo = '$año'
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                        }
                    else{
                        //no hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND ano_archivo = '$año'
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                    WHERE id_tipocabecera = 1 AND ano_archivo = '$año'                            
                    AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                /* else{
                    //no hay busqueda (no debe pasar)
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo WHERE ano_archivo = '$año'order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                } */
            }
        }
        else{
            //no hay año
            if($tipo != ['sel']){
                //se eligio un tipo
                if($subtipo != ['sel']){
                    //se eligio un subtipo
                    if($busqueda != null){
                        //hay una busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 
                        AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' AND id_subtipoarchivo = '$subtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
                }
                else{
                    //no hay subtipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo 
                        WHERE id_tipocabecera =1 AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo' 
                        AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                        }
                }
            }
            else{
                //no se eligio tipo
                if($busqueda != null){
                    //hay busqueda
                    $archivos = DB::select( DB::raw("SELECT * FROM iprodha.vw_dig_parabuscararchivo WHERE
                        id_tipocabecera  AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%') order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc"));
                    }
            }      
        }
        
    }

    foreach($archivos as $a){
        $a->path_archivo = substr($a->path_archivo, 14);
        
    } 
    $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
    $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
    
    return view('archivo.index')
        ->with('TipoDocumento',$TipoDocumento)
        ->with('SubTipoDocumento',$SubTipoDocumento)
        ->with('archivos',$archivos);

} 
    public function getpdf($path){
        $pathsinip = substr($path, 14);
        $file = Storage::get($pathsinip);
        return $file;
    }
}