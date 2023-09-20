<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_legajos;
use App\Models\Iprodha\App_boletas;


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
        $legajos = App_legajos::where('cuil', '=', $request->cuil)->get();
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
        $boletas = App_boletas::where('ope', '=', $request->ope)        
        ->where('barrio', '=', $request->barrio)
        ->where('adju', '=', $request->adju)
        ->where('nro_cta', '>=', 'ult_fac -12 ')->get();
        return response()->json($boletas);
    }
}