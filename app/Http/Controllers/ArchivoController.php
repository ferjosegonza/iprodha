<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Iprodha\Vw_dig_parabuscararchivo;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_subtipoarchivo;


class ArchivoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }


    public function consultar(){
        $archivos = Vw_dig_parabuscararchivo::orderBy('ano_archivo', 'desc')->simplePaginate();
       foreach($archivos as $a){
            $a->path_archivo = 'http:\\\\localhost'.substr($a->path_archivo, 14);
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

    public function buscar(){
        return view('archivo.index');
    }
}