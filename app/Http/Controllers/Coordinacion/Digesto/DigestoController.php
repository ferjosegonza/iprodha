<?php

namespace App\Http\Controllers\Coordinacion\Digesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Iprodha\Dig_archivos;
use App\Models\Iprodha\Dig_subtipoarchivo;
use App\Models\Iprodha\Dig_digesto;
use App\Models\Iprodha\Dig_digesto_areas;
use App\Models\Personal\Vw_dig_areas;


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
        $areas = Vw_dig_areas::orderBy('area')->get();
        return view('Digesto.index')

        ->with('tipos', $tipos)
        ->with('subtipos', $subtipos)
        ->with('areas', $areas);
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

    public function guardar(Request $request){
        $datosValidos = $request->validate([
            'id0' => 'required',
            'idn' => 'required',
            'obs' => 'required'
        ]);

        $digesto = new Dig_digesto;
        $res = $digesto->guardar($request->id0, $request->idn, $request->obs);
        return $res;
    }

    public function areas(Request $request){
        $data = Dig_digesto_areas::where('id_archivo', '=', $request->id)
                ->join('PERSONAL.VW_DIG_AREAS', 'PERSONAL.VW_DIG_AREAS.idarea', '=', 'iprodha.dig_digesto_areas.id_area')
                ->get();
        //$areas_original = Dig_digesto_areas::where('id_archivo', '=', $request->id)->get();
        return response()->json($data);
    }

    public function remove_area(Request $request){
        $area = Dig_digesto_areas::where('id_archivo', '=', $request->id_archivo)
                ->where('id_area', '=', $request->id_area)
                ->first();
        $res = $area->delete();
        return $res;
    }

    public function add_area(Request $request){
        $area = new Dig_digesto_areas;
        $area->id_area = $request->id_area;
        $area->id_archivo = $request->id_archivo;
        $res = $area->save();
        return $res;
    }
}
