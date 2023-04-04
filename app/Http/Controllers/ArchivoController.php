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

        $TipoDocumento = Dig_tipoarchivo::orderBy('id_tipoarchivo')->get();
        
        return view('archivo.index')
            ->with('TipoDocumento',$TipoDocumento)
            ->with('archivos',$archivos);
    }

    public function buscar(){
        return view('archivo.index');
    }

    public function subtipos(Request $request){
        $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipoarchivo', '=', $request->id)->get();
        return $SubTipoDocumento;
        $response['data'] = $SubTipoDocumento;        
        return response()->json(['response' => $response]);
    }
}