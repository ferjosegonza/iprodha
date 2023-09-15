<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_legajos;

class AuthAppController extends Controller
{
    public function legajos(Request $request){
        return response()->json($request);
        $validator = Validator::make($request->all(), [
            'cuil' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $legajos = App_legajos::where('cuil', '=', $request->cuil)->get();
        return response()->json($legajos);
    }
}