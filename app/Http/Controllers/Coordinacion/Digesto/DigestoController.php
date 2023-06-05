<?php

namespace App\Http\Controllers\Coordinacion\Digesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_archivos;
use App\Models\Iprodha\Dig_subtipoarchivo;


class DigestoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(){
        $tipos = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->where('id_tipoarchivo', '=', 1)->get();
       // $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->get(); se necesita agregar un atributo de modificable
        $subtipos = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->where('id_subtipoarchivo', '=', 3)->get();
        return view('Digesto.index')
        ->with('tipos', $tipos)
        ->with('subtipos', $subtipos);
    }

    public function buscarArchivo(Request $request){
        //return $request;
        $archivo = Dig_archivos::where('id_tipoarchivo', '=', $request->tipo)
                    ->where('id_subtipoarchivo', '=', $request->subtipo)
                    ->where('nro_archivo', '=', $request->doc)->first();
        //return $archivo;
        $archivo->path_archivo = substr($archivo->path_archivo, 14);
        return response()->json($archivo);
    }
}
