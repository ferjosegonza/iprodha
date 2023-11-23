<?php

namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_usuario;

class AuthAppController extends Controller
{
    public function loginCiudadano(Request $request){
        return view('app.loginCiudadano');
    }

    public function iprodhaCiudadano(Request $request){
        return view('app.iprodhaCiudadano');
    }

    public function exitoCiudadano(Request $request){
        return view('app.exitoCiudadano');
    }

    public function registerApp(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        if(App_usuario::where('usuario', '=', $request->usuario)->first()){
            return response()->json(['message' => 'User already registered']);
        }
        else{
            $user = new App_usuario;
            $user->crear($request->nombre, $request->email, $request->usuario);
            return response()->json(['message' => 'User registered successfully']);
        }
    }

    public function loginApp(Request $request){
        $validator = Validator::make($request->all(), [
            'usuario' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = App_usuario::where('usuario', '=', $request->usuario)->first();
        $user->token = md5(uniqid().rand(1000000, 9999999));
        $user->save();
        return response()->json($user);
    }
}