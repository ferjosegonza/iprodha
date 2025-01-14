<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_legajos;
use App\Models\Iprodha\App_boletas;
use DB;

class LegajoAppController extends Controller
{
    public function legajos(Request $request){
        $validator = Validator::make($request->all(), [
            'cuil' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } 
        $query = "SELECT l.adju,
        l.operatoria,
        l.ope,
        l.barrio,
        l.nombre_barrio,
        l.nombre, l.cuil, l.situacion_habitacional,
        l.adeuda
        from IPRODHA.app_legajos l
        where cuil = $request->cuil";
        $legajos = DB::select( DB::raw($query));
        return response()->json($legajos);
    }

    public function boletas(Request $request){
        $validator = Validator::make($request->all(), [
            'barrio' => 'required',
            'ope' => 'required',
            'adju' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $query = "SELECT * from IPRODHA.APP_BOLETAS 
        where OPE = '$request->ope'
        and BARRIO = $request->barrio
        and ADJU = $request->adju
        and NRO_CTA >= ult_fac -12";
        $boletas = DB::select( DB::raw($query));
        return response()->json($boletas);
    }

    public function boletasImpagas(Request $request){
        $validator = Validator::make($request->all(), [
            'barrio' => 'required',
            'ope' => 'required',
            'adju' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $query = "SELECT * from IPRODHA.APP_BOLETAS
        where OPE = '$request->ope'
        and BARRIO = $request->barrio
        and ADJU = $request->adju
        and pagable = 1";
        $boletas = DB::select( DB::raw($query));
        return response()->json($boletas);
    }

    public function adeuda(Request $request) { 
        $validator = Validator::make($request->all(), [
            'barrio' => 'required',
            'ope' => 'required',
            'adju' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $query = "SELECT count(estado) as adeuda from IPRODHA.APP_BOLETAS
        where OPE = '$request->ope'
        and BARRIO = $request->barrio
        and ADJU = $request->adju
        and ESTADO = 'Impago'";
        $boletas = DB::select( DB::raw($query));
        return response()->json($boletas);
    }
}