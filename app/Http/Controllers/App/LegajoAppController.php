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
        //return response()->json($request);
        $validator = Validator::make($request->all(), [
            'cuil' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        } 
        $query = "SELECT l.operatoria, l.barrio, l.adju, l.nombre_barrio, l.cuil,
        l.situacion_habitacional, l.ope, l.nombre, B.adeuda FROM IPRODHA.APP_LEGAJOS L
        INNER JOIN (select adju, ope, barrio,count(estado) as adeuda 
        from iprodha.app_boletas where estado = 'Impago' 
        group by adju, ope, barrio) b
        ON B.adju  = L.adju AND B.ope = L.ope AND L.barrio = B.barrio
        WHERE CUIL = 20287390557 ";
        $legajos = DB::select( DB::raw($query));
        //$legajos = App_legajos::where('cuil', '=', $request->cuil)->get();
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