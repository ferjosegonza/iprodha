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
use App\Models\Iprodha\Dig_asunto;
use Illuminate\Support\Facades\Storage;
use DB;


class ArchivoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

public function consultar(){
    //$boletin = DB::table('iprodha.Vw_dig_parabuscararchivo')->max('fecha_boletin');
    //$archivos = Vw_dig_parabuscararchivo::where('id_tipocabecera', '=', 1)->where('fecha_boletin', '=', $boletin)->orderBy('nombre_corto', 'asc')->orderBy('ano_archivo', 'desc')->orderBy('mes_archivo', 'desc')->orderBy('dia_archivo', 'desc')->get();
    $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
    $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
    $Tags = Dig_tags::where('estructura','=','1')->orderBy('descripcion')->get();
    
    return view('archivo.index')
        ->with('TipoDocumento',$TipoDocumento)
        ->with('SubTipoDocumento',$SubTipoDocumento)
        ->with('Tags',$Tags);
}

public function consultarBoletin(Request $request){
    $boletin = DB::table('iprodha.Vw_dig_parabuscararchivo')->max('fecha_boletin');
    $archivos = Vw_dig_parabuscararchivo::where('id_tipocabecera', '=', 1)->where('fecha_boletin', '=', $boletin)->orderBy('nombre_corto', 'asc')->orderBy('ano_archivo', 'desc')->orderBy('mes_archivo', 'desc')->orderBy('dia_archivo', 'desc')->get();
    return response()->json($archivos);
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
    if($request->tag != 'sel'){
        $tag =  explode('|',$request->tag);
    }
    else{
        $tag=null;
    }
    $info = $request->input_tag;    

    $query = "SELECT * FROM iprodha.vw_dig_parabuscararchivo WHERE id_tipocabecera = 1";
    if($request->betwenyears == 'on'){
        //checkbox on    
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
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
        $año = $request->ano;
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
        if(is_numeric($busqueda)){
            $query = $query . " AND (NRO_ARCHIVO='$busqueda' or claves_archivo LIKE '%$busqueda%')";
        }
        else{
            $query = $query . " AND claves_archivo LIKE '%$busqueda%'";
        }
    }
    if($tag != null and $info != null){
        $query = $query . " AND claves_archivo LIKE '%<$tag[1]:$info%>%'";
    }
    //ordenamos
    $query = $query . " order by nombre_corto asc, ano_archivo desc, mes_archivo desc, dia_archivo desc";


    $archivos = DB::select( DB::raw($query));

    return response()->json($archivos);
} 

public function getpdf($path){
    $file = Storage::get($pathsinip);
    return $file;
}

public function obtenerTagFormato(Request $request){
    $idtag = explode('|', $request->id);
    $tag = Dig_tags::where("id_tag", "=", $idtag[0])->first();
    if($tag->estructura == 2){
        $query = "SELECT dt.id_tag, dt.descripcion, id_tag_hijo, orden, sc1.descripcion as deschijo, 
        sc1.dato_tipo, sc1.dato from iprodha.dig_tags dt inner join iprodha.dig_tags_complejo dtc 
        on dtc.id_tag_padre = dt.id_tag 
        inner join (select * from iprodha.dig_tags where estructura = 1)sc1
        on sc1.id_tag = dtc.id_tag_hijo 
        WHERE dt.id_tag = $tag->id_tag";     
        $tag = DB::select( DB::raw($query));   
    }
    return response()->json($tag);
}

public function digitalizar(){
    $TipoDocumento = Dig_tipoarchivo::orderBy('nombre_corto')->get();
    $SubTipoDocumento = Dig_subtipoarchivo::orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
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
                ->where('orden', '=', $request->orden)
                ->where('nro_archivo','=', $request->doc)
                ->where('ano_archivo','=',$fecha[0])
                ->where('mes_archivo','=',$fecha[1])
                ->where('dia_archivo','=',$fecha[2])
                ->first();
  
    return response()->json(['response' => $archivo]);
}

public function getArchivos(Request $request){  
    if($request->fecha != null){
        $fecha = explode("-", $request->fecha);
        $query = "select da.id_archivo, id_tipoarchivo, id_subtipoarchivo, ano_archivo,
        mes_archivo, dia_archivo, nro_archivo, claves_archivo, path_archivo,
        nombre_archivo, fecha_carga, id_tipocabecera, fecha_boletin, orden, asunto from iprodha.dig_archivos da 
        left join iprodha.dig_asunto ds 
        on ds.id_archivo = da.id_archivo 
        where id_tipoarchivo = $request->tipo 
        and id_subtipoarchivo = $request->subtipo 
        and nro_archivo = '$request->doc'
        and ano_archivo = $fecha[0] 
        and mes_archivo = $fecha[1] 
        and dia_archivo = $fecha[2]
        order by nombre_archivo";
        $archivo = DB::select( DB::raw($query));
    }
    else{
        $query = "select da.id_archivo, id_tipoarchivo, id_subtipoarchivo, ano_archivo,
        mes_archivo, dia_archivo, nro_archivo, claves_archivo, path_archivo,
        nombre_archivo, fecha_carga, id_tipocabecera, fecha_boletin, orden, asunto from iprodha.dig_archivos da 
        left join iprodha.dig_asunto ds 
        on ds.id_archivo = da.id_archivo 
        where id_tipoarchivo = $request->tipo 
        and id_subtipoarchivo = $request->subtipo 
        and nro_archivo = '$request->doc'
        order by nombre_archivo";
        $archivo = DB::select( DB::raw($query));
    }
    return response()->json($archivo);
}

public function tags(Request $request){
    $query = "SELECT * FROM IPRODHA.dig_tagsxtipodoc dxt 
    inner join IPRODHA.dig_tags dt
    on dxt.id_tag = dt.id_tag
    where id_tipoarchivo = '$request->tipo' 
    and id_subtipoarchivo = '$request->subtipo'
    and id_tipocabecera = $request->cabecera";
    $tags = DB::select( DB::raw($query));

    return response()->json($tags);
}

public function getCampos(Request $request){
    $tag = Dig_tag_busqueda::where('id_tag','=',$request->id)->first();   
    return response()->json($tag);
}

public function getSelects(Request $request){
    $tag = Dig_tag_busqueda::where('id_tag','=',$request->id)->first();
    if($tag->campo2 != null){
        $query= "SELECT $tag->campo1 as campo1, $tag->campo2 as campo2 FROM $tag->esquema.$tag->tabla order by campo1";
    }
    else{
        $query = $query= "SELECT $tag->campo1 as campo1 FROM $tag->esquema.$tag->tabla order by campo1";
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
        $query = $query . " order by id_tag, orden";
        $tags = DB::select( DB::raw($query));
    }
    else{
        $tags=null;
    }    

    return response()->json($tags);
}

public function busquedaDirigida(Request $request){
    $busqueda = Dig_tag_busqueda::where('id_tag','=', $request->id)->first();
    
    $query = "SELECT $busqueda->campo1 as campo1 FROM $busqueda->esquema.$busqueda->tabla 
            WHERE $busqueda->campo1 LIKE '%$request->texto%'";
    $datos = DB::select( DB::raw($query));
    return response()->json($datos);
}

public function crear(Request $request){   
    //
    $fecha = explode("-", $request->fecha);
    //
    $archivo = new Dig_archivos;
    $archivo->id_tipoarchivo = $request->tipo;
    $archivo->id_subtipoarchivo = $request->subtipo;
    $archivo->nro_archivo = $request->doc;
    $archivo->ano_archivo = $fecha[0];
    $archivo->mes_archivo = $fecha[1];
    $archivo->dia_archivo = $fecha[2];
    $archivo->claves_archivo = $request->claves;
    $archivo->orden = $request->orden;
    $archivo->id_tipocabecera = $request->cabecera;

    $path = Dig_subtipoarchivo::where('id_tipocabecera', '=', $request->cabecera)
    ->where('id_tipoarchivo', '=', $request->tipo)
    ->where('id_subtipoarchivo', '=', $request->subtipo)
    ->first();
    if($path != null){
        $archivo->path_archivo = $path->path_archivo;
    }
    //guardar los archivos
    if($request->pdf == 'on'){
        $fileName = $request->pdfname;
    }
    else{
        $fileName = 'No se ha cargado un archivo';
    }
    $archivo->nombre_archivo = $fileName;
    $res = $archivo->save();
    //
    $query = Dig_archivos::where('id_tipocabecera', '=', $request->cabecera)
    ->where('id_tipoarchivo', '=', $archivo->id_tipoarchivo)
    ->where('id_subtipoarchivo', '=', $archivo->id_subtipoarchivo)
    ->where('nro_archivo', '=', $archivo->nro_archivo)
    ->where('ano_archivo', '=', $archivo->ano_archivo)
    ->where('mes_archivo', '=', $archivo->mes_archivo)
    ->where('dia_archivo', '=', $archivo->dia_archivo)
    ->where('orden', '=', $archivo->orden)
    ->first();
    //
    if($request->asunto != ''){
        $asunto = new Dig_asunto;
        $asunto->id_archivo = $query->id_archivo;
        $asunto->asunto = $request->asunto;
        $asunto->save();
    }    
    //
    return response()->json($path);    
}

public function modificar(Request $request){
    //return $request;
    $fecha = is_string($request->fecha) ? explode("-", $request->fecha) : null;
    //
    $archivo = Dig_archivos::where('id_archivo','=', $request->id)
                ->first();
    //
    $archivo->claves_archivo = $request->claves;
    $archivo->orden = $request->orden;
    $archivo->ano_archivo = $fecha[0];
    $archivo->mes_archivo = $fecha[1];
    $archivo->dia_archivo = $fecha[2];
    $archivo->id_tipoarchivo = $request->tipo;
    $archivo->id_subtipoarchivo = $request->subtipo;
    $archivo->id_tipocabecera = $request->cabecera;
    $archivo->nombre_archivo = $request->pdfname;
    $archivo->nro_archivo = $request->doc;
    $path = Dig_subtipoarchivo::where('id_tipocabecera', '=', $request->cabecera)
    ->where('id_tipoarchivo', '=', $request->tipo)
    ->where('id_subtipoarchivo', '=', $request->subtipo)
    ->first();
    if($path != null){
        $archivo->path_archivo = $path->path_archivo;
    }
    $res = $archivo->save();
    //
     $asunto = Dig_asunto::where('id_archivo', '=', $archivo->id_archivo)->first();
    if($asunto != null or $request->asunto != ''){        
        if($asunto == null){
            $asunto = new Dig_asunto;
            $asunto->id_archivo = $archivo->id_archivo;
            $asunto->asunto = $request->asunto;
            $asunto->save();
        }
        else{
            $asunto->asunto = $request->asunto;
            $asunto->save();
        }
            
    }   
    //
    return response()->json($res);    
}

public function derivados(Request $request){
    $busqueda = Dig_tag_busqueda::where('id_tag', '=', $request->id)->first();
    
    if( is_string($request->value)){
        $query = "SELECT $busqueda->campo2 as dato FROM $busqueda->esquema.$busqueda->tabla where $busqueda->campo1 like '%$request->value%'";
    }
    else{
        $query = "SELECT $busqueda->campo2 as dato FROM $busqueda->esquema.$busqueda->tabla where $busqueda->campo1 = $request->value";
    }


    $datos = DB::select( DB::raw($query));
    return response()->json($datos);
}

public function buscarArchivosRRHH(Request $request){

    $query = "SELECT id_archivo, nro_archivo, t.nombre_corto as tipo, s.dessubtipoarchivo as subtipo, 
    claves_archivo, i.path_archivo, i.nombre_archivo, dia_archivo, mes_archivo, ano_archivo
    from iprodha.dig_archivos i
    left join iprodha.dig_tipoarchivo t on (i.id_tipoarchivo = t.id_tipoarchivo)
    and (i.id_tipocabecera = t.id_tipocabecera)
    left join iprodha.dig_subtipoarchivo s on (i.id_subtipoarchivo = s.id_subtipoarchivo) 
    and (s.id_tipoarchivo = t.id_tipoarchivo)
    and (i.id_tipocabecera = s.id_tipocabecera)
    where i.id_tipoarchivo = $request->tipo and 
    i.id_subtipoarchivo = $request->subtipo and
    i.nro_archivo = '$request->nro'
    and i.id_tipocabecera = $request->cabecera";
    $archivos = DB::select( DB::raw($query));
    return response()->json($archivos);
}

public function buscarDNI(Request $request){
    $archivo = Dig_archivos::where('id_tipocabecera', '=', '3')
    ->where('id_tipoarchivo', '=', '18')
    ->where('id_subtipoarchivo', '=', '1')
    ->where('nro_archivo', '=', $request->dni)->first();
    $str=$archivo->path_archivo . $archivo->nombre_archivo;
    return response()->json($str);    
}

public function buscarPorId(Request $request){
    $archivo = Dig_archivos::where('id_archivo', '=', $request->id)->first();
    return response()->json($archivo);
}
}

