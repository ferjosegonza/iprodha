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
        $archivos = Vw_dig_parabuscararchivo::where('id_tipocabecera', '=', 1)->where('fecha_boletin', '=', $boletin)->orderBy('ano_archivo', 'desc')->get();
       foreach($archivos as $a){
            $a->path_archivo = substr($a->path_archivo, 14);
        } 
        $TipoDocumento = Dig_tipoarchivo::orderBy('nombre_corto')->get();
        $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
        
        return view('archivo.index')
            ->with('TipoDocumento',$TipoDocumento)
            ->with('SubTipoDocumento',$SubTipoDocumento)
            ->with('archivos',$archivos);
    }

    public function buscar(Request $request){

        //return $request;
        
        if($request->ano=="sel" and $request->fecha1 == null and $request->fecha2 ==null and $request->tipo == "sel" and $request->subtipo== "sel" and $request->busqueda ==null){
            $archivos = Vw_dig_parabuscararchivo::where('id_tipocabecera', '=', 1)->orderBy('ano_archivo', 'desc')->simplePaginate(100);
            foreach($archivos as $a){
                    $a->path_archivo = substr($a->path_archivo, 14);
                } 
                $TipoDocumento = Dig_tipoarchivo::orderBy('nombre_corto')->get();
                $SubTipoDocumento = Dig_subtipoarchivo::orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
                
                return view('archivo.index')
                    ->with('TipoDocumento',$TipoDocumento)
                    ->with('SubTipoDocumento',$SubTipoDocumento)
                    ->with('archivos',$archivos);
        }

        $tipo= explode('|',$request->tipo);
        if($request->tipo != 'sel')
        {
            $tipo = $tipo[0];
        }
        $subtipo = explode('|', $request->subtipo);
        if($request->subtipo != 'sel'){
            $subtipo = $subtipo[2];
        }    
        $busqueda = $request->busqueda;
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;

        if($request->betwenyears == 'on'){
            //checkbox on
           
            if($fecha1 != null and $fecha2 != null){
                $fecha1 = explode('-',$request->fecha1);
                $fecha2 = explode('-',$request->fecha2);
                $fe1y=$fecha1[0];
                $fe1m=$fecha1[1];
                $fe1d=$fecha1[2];
                $fe2y=$fecha2[0];
                $fe2m=$fecha2[1];
                $fe2d=$fecha2[2];
                //hay un rango de fecha
                if($tipo !=['sel']){
                    //se eligio un tipo
                    if($subtipo != ['sel']){
                        //se eligio un subtipo
                        if($busqueda != null){
                            //hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                            ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                            ->whereBetween('dia_archivo',[$fe1d,$fe2d])
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                            ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                            ->whereBetween('dia_archivo',[$fe1d,$fe2d])
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                            ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                            ->whereBetween('dia_archivo',[$fe1d,$fe2d])
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                            ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                            ->whereBetween('dia_archivo',[$fe1d,$fe2d])
                            ->where('id_tipoarchivo', '=', $tipo)->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                        ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                        ->whereBetween('dia_archivo',[$fe1d,$fe2d])
                        ->where('nro_archivo','=',$busqueda)
                        ->orWhere('claves_archivo','LIKE', $busqueda)->get();}
                    else{
                        //no hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::whereBetween('ano_archivo',[$fe1y,$fe2y])
                        ->whereBetween('mes_archivo',[$fe1m,$fe2m])
                        ->whereBetween('dia_archivo',[$fe1d,$fe2d])->get();
                    }
                }
            }
            else if($fecha1 != null and $fecha2 == null){
                $fecha1 = explode('-',$request->fecha1);
                $fe1y=$fecha1[0];
                $fe1m=$fecha1[1];
                $fe1d=$fecha1[2];
                //hay una fecha minima
                if($tipo !=['sel']){
                    //se eligio un tipo
                    if($subtipo != ['sel']){
                        //se eligio un subtipo
                        if($busqueda != null){
                            //hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                            ->where('mes_archivo','>=',$fe1m)
                            ->where('dia_archivo','>=',$fe1d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                            ->where('mes_archivo','>=',$fe1m)
                            ->where('dia_archivo','>=',$fe1d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                            ->where('mes_archivo','>=',$fe1m)
                            ->where('dia_archivo','>=',$fe1d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                            ->where('mes_archivo','>=',$fe1m)
                            ->where('dia_archivo','>=',$fe1d)
                            ->where('id_tipoarchivo', '=', $tipo)->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                        ->where('mes_archivo','>=',$fe1m)
                        ->where('dia_archivo','>=',$fe1d)
                        ->where('nro_archivo','=',$busqueda)
                        ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                    }
                    else{
                        //no hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe1y)
                        ->where('mes_archivo','>=',$fe1m)
                        ->where('dia_archivo','>=',$fe1d)->get();
                    }
                }
            }
            else if($fecha1 == null and $fecha2 != null){
                //Hay una fecha maxima
                $fecha2 = explode('-',$request->fecha2);
                $fe2y=$fecha2[0];
                $fe2m=$fecha2[1];
                $fe2d=$fecha2[2];
                if($tipo !=['sel']){
                    //se eligio un tipo
                    if($subtipo != ['sel']){
                        //se eligio un subtipo
                        if($busqueda != null){
                            //hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                            ->where('mes_archivo','>=',$fe2m)
                            ->where('dia_archivo','>=',$fe2d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                            ->where('mes_archivo','>=',$fe2m)
                            ->where('dia_archivo','>=',$fe2d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                            ->where('mes_archivo','>=',$fe2m)
                            ->where('dia_archivo','>=',$fe2d)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                            ->where('mes_archivo','>=',$fe2m)
                            ->where('dia_archivo','>=',$fe2d)
                            ->where('id_tipoarchivo', '=', $tipo)->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                        ->where('mes_archivo','>=',$fe2m)
                        ->where('dia_archivo','>=',$fe2d)
                        ->where('nro_archivo','=',$busqueda)
                        ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                    }
                    else{
                        //no hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','>=',$fe2y)
                        ->where('mes_archivo','>=',$fe2m)
                        ->where('dia_archivo','>=',$fe2d)->get();
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
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
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
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)
                            ->where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                            }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)
                            ->where('id_tipoarchivo', '=', $tipo)->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                    else{
                        //no hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('ano_archivo','=',$año)->get();
                    }
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
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                        else{
                            //no hay una busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('id_subtipoarchivo', '=', $subtipo)->get();
                        }
                    }
                    else{
                        //no hay subtipo
                        if($busqueda != null){
                            //hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                            }
                        else{
                            //no hay busqueda
                            $archivos = Vw_dig_parabuscararchivo::where('id_tipoarchivo', '=', $tipo)
                            ->get();
                        }
                    }
                }
                else{
                    //no se eligio tipo
                    if($busqueda != null){
                        //hay busqueda
                        $archivos = Vw_dig_parabuscararchivo::where('nro_archivo','=',$busqueda)
                            ->orWhere('claves_archivo','LIKE','%'.strtoupper($busqueda).'%')->get();
                        }
                }      
            }
            
        }






        foreach($archivos as $a){
            $a->path_archivo = substr($a->path_archivo, 14);
            
        } 
        $TipoDocumento = Dig_tipoarchivo::orderBy('nombre_corto')->get();
        $SubTipoDocumento = Dig_subtipoarchivo::orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
        
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