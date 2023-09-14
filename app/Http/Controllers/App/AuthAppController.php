<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_usuario;

class AuthAppController extends Controller
{
    public function registerApp(Request $request){
        //return response()->json($request);
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email',
            'contra' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = new App_usuario;
        $user->crear($request->nombre, $request->email, $request->usuario, $request->contra);

        return response()->json(['message' => 'User registered successfully']);
    }

    public function loginApp(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'contra' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }   

        $user = App_usuario::where('mail', '=', $request->email)->first();
        $res = password_verify($request->contra, $user->contraseÑa);        
        if($res){
            $user->token = md5(uniqid().rand(1000000, 9999999));
            $user->save();
            return response()->json($user->token); 
        }
        else{
           return response()->json($res); 
        }
        
    }
}