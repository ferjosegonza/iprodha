<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iprodha\Vw_dig_parabuscararchivo;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_subtipoarchivo;
use App\Models\Iprodha\Dig_archivos;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Dig_tags;
use App\Models\Iprodha\Localidad;
use App\Models\Iprodha\Dig_tag_busqueda;
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
    $año = $request->ano;

    $query = "SELECT * FROM iprodha.vw_dig_parabuscararchivo WHERE id_tipocabecera = 1";
    if($request->betwenyears == 'on'){
        //checkbox on    
        if($fecha1 != null and $fecha2 != null){
            //rango de fechas
            $query = $query . " AND fecha_archivo between to_date('$fecha1', 'YYYY-MM-DD') and to_date('$fecha2', 'YYYY-MM-DD')";
        }
        else if ($fecha1 != null and $fecha2 == null){
            //fecha bigger than
            $query = $query . " AND fecha_archivo >= to_date('$fecha1', 'YYYY-MM-DD')";
        }
        else if($fecha1 == null and $fecha2 != null){
            //fecha less than
            $query = $query . " AND fecha_archivo <= to_date('$fecha2', 'YYYY-MM-DD')";
        }
    }
    else{     
        //checkbox off
        if($año != 'sel'){
            //hay un año
            $query = $query . " AND ano_archivo = '$año'";
        }
    }
    if($tipo != ['sel']){
        //hay un tipo
        $query = $query . " AND id_tipoarchivo = '$tipo' AND nombre_corto like '$nomtipo'";
        if($subtipo != ['sel']){
            //hay un subtipo
            $query = $query . " AND id_subtipoarchivo = '$subtipo'";
        }
    }
    if($busqueda != null){
        //hay una busqueda
        $query = $query . " AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')";
    }    
    //ordenamos
    $query = $query . " order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc";


    $archivos = DB::select( DB::raw($query));

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


public function digitalizar(){
    $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
    $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
    $Empresas = Empresa::orderBy('nom_emp','asc')->get();
    $Localidades = Localidad::select('nom_loc','id_loc')->get();
    $Tags = Dig_tags::orderBy('descripcion','asc')->get();

    return view('archivo.digitalizar')
        ->with('TipoDocumento',$TipoDocumento)
        ->with('SubTipoDocumento',$SubTipoDocumento)
        ->with('Empresas', $Empresas)
        ->with('Tags', $Tags)
        ->with('Localidades',$Localidades);
}

public function check(Request $request){

    $fecha = explode("-", $request->fecha);

    $archivo = Dig_archivos::where('id_tipoarchivo','=', $request->tipo)
                ->where('id_subtipoarchivo','=', $request->subtipo)
                ->where('nro_archivo','=', $request->doc)
                ->where('ano_archivo','=',$fecha[0])
                ->where('mes_archivo','=',$fecha[1])
                ->where('dia_archivo','=',$fecha[2])
                ->first();
    if($archivo != null){
        $archivo->path_archivo = substr($archivo->path_archivo, 14);
    }
    

    return response()->json(['response' => $archivo]);
}


public function tags(Request $request){
    $fecha = explode("-", $request->fecha);
    $query = "SELECT * FROM IPRODHA.dig_tagsxtipodoc dxt 
    inner join IPRODHA.dig_tags dt
    on dxt.id_tag = dt.id_tag
    where id_tipoarchivo = '$request->tipo' 
    and id_subtipoarchivo = '$request->subtipo'
    and id_tipocabecera = 1";
    $tags = DB::select( DB::raw($query));

    return response()->json(['response' => $tags]);
}

public function getCampos(Request $request){
    $tag = Dig_tag_busqueda::where('id_tag','=',$request->id)->first();   
    return response()->json($tag);
}

public function getSelects(Request $request){
    $tag = Dig_tag_busqueda::where('id_tag','=',$request->id)->first();
    if($tag->campo2 != null){
        $query= "SELECT $tag->campo1 as campo1, $tag->campo2 as campo2 FROM $tag->esquema.$tag->tabla";
    }
    else{
        $query = $query= "SELECT $tag->campo1 as campo1 FROM $tag->esquema.$tag->tabla";
    }    
    $opciones = DB::select( DB::raw($query));
    return response()->json($opciones);
}

public function complejos(Request $request){

    $query="select dt.id_tag, dt.descripcion, id_tag_hijo, orden, sc1.descripcion as deschijo, sc1.dato_tipo, sc1.dato 
    from iprodha.dig_tags dt 
    inner join iprodha.dig_tags_complejo dtc on
    dtc.id_tag_padre = dt.id_tag 
    inner join (select * from iprodha.dig_tags where estructura = 1)sc1
    on sc1.id_tag = dtc.id_tag_hijo WHERE";

    if($request->tags != null){
        $size=sizeof($request->tags); 

        for($i=0; $i<$size; $i++){
            if($i==0){
                $query = $query . " dt.id_tag =" . strval($request->tags[$i]);
            }
            else{
                $query = $query . " OR dt.id_tag =" . strval($request->tags[$i]);
            } 
        }  
        $tags = DB::select( DB::raw($query));
    }
    else{
        $tags=null;
    }    

    return response()->json(['response' => $tags]);
}


public function busquedaDirigida(Request $request){

   $busqueda = Dig_tag_busqueda::where('id_tag','=', $request->id)->first();
    
    $query = "SELECT $busqueda->campo1 as campo1 FROM $busqueda->esquema.$busqueda->tabla 
            WHERE $busqueda->campo1 LIKE '%$request->texto%'";
    $datos = DB::select( DB::raw($query));
    return response()->json($datos);
}

public function borrar(Request $request){
    $fecha = explode("-", $request->fecha);

    $res = Dig_archivos::where('id_tipoarchivo','=', $request->tipo)
                ->where('id_subtipoarchivo','=', $request->subtipo)
                ->where('nro_archivo','=', $request->doc)
                ->where('ano_archivo','=',$fecha[0])
                ->where('mes_archivo','=',$fecha[1])
                ->where('dia_archivo','=',$fecha[2])
                ->first()
                ->destroy();

    return response()->json($res);    
}

public function crear(Request $request){
    $fecha = explode("-", $request->fecha);

    $archivo = new Dig_archivos;
    $archivo->id_tipoarchivo = $request->tipo;
    $archivo->id_subtipoarchivo = $request->subtipo;
    $archivo->nro_archivo = $request->doc;
    $archivo->ano_archivo = $fecha[0];
    $archivo->mes_archivo = $fecha[1];
    $archivo->dia_archivo = $fecha[2];
    $archivo->claves_archivo = $request->claves;
    $archivo->orden = $request->orden;
    $archivo->id_tipocabecera = 1;  //preguntar el tipo de cabecera
    $archivo->fecha_carga = date("Y-m-d h:i:sa");

    //ver cuestion de guardar los archivos

    $res = $archivo->save();
    

    return response()->json($res);    
}

public function modificar(Request $request){
    $fecha = explode("-", $request->fecha);

    $archivo = Dig_archivos::where('id_tipoarchivo','=', $request->tipo)
                ->where('id_subtipoarchivo','=', $request->subtipo)
                ->where('nro_archivo','=', $request->doc)
                ->where('ano_archivo','=',$fecha[0])
                ->where('mes_archivo','=',$fecha[1])
                ->where('dia_archivo','=',$fecha[2])
                ->first();

    $archivo->id_tipoarchivo = $request->tipo;
    $archivo->id_subtipoarchivo = $request->subtipo;
    $archivo->nro_archivo = $request->doc;
    $archivo->ano_archivo = $fecha[0];
    $archivo->mes_archivo = $fecha[1];
    $archivo->dia_archivo = $fecha[2];
    $archivo->claves_archivo = $request->claves;
    $archivo->orden = $request->orden;

    //ver cuestion de guardar los archivos

    $res = $archivo->save();

    return response()->json($res);    
}


}

