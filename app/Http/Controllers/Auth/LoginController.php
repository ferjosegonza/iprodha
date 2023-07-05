<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Crear usuario DB
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Dba_users;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use App\Models\Iprodha\Lav_user_db;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $existeUser = Lav_user_db::where("id_user_lav", Auth::user()->id)->first();

            if (!isset($existeUser)){
                $user = "WEB-".Auth::user()->id;
                $pass = $request->input('password');

                $creaUserDB = 'CREATE USER "'.$user.'" PROFILE DEFAULT IDENTIFIED BY "'.$pass.'a" DEFAULT TABLESPACE USERS ACCOUNT UNLOCK';
                    // DB::select(DB::raw($creaUserDB));
                    DB::statement($creaUserDB);
                    $permisoUserDB = 'GRANT CONNECT,RESOURCE,TABLAVIEJA,TABLANUEVA,TABLAGENERAL TO "'.$user.'"';
                    // DB::select(DB::raw($permisoUserDB));
                    DB::statement($permisoUserDB);

                    Lav_user_db::create([
                        'id_user_lav' => Auth::user()->id,

                        'pass_lav' => Crypt::encryptString($request->input('password').'a'),

                        'user_lav' => $user,
                    ]);
                
                // try {
                //     $creaUserDB = 'CREATE USER "'.$user.'" PROFILE DEFAULT IDENTIFIED BY "'.$pass.'a" DEFAULT TABLESPACE USERS ACCOUNT UNLOCK';
                //     DB::select(DB::raw($creaUserDB));
                //     // $permisoUserDB = 'GRANT CONNECT,RESOURCE,TABLAVIEJA,TABLANUEVA,TABLAGENERAL TO "'.$user.'"';
                //     // DB::select(DB::raw($permisoUserDB));

                //     Lav_user_db::create([
                //         'id_user_lav' => Auth::user()->id,
                //         'pass_lav' => Crypt::encryptString($request->input('password').'a'),
                //         'user_lav' => $user,
                //     ]);
                // } catch (\Throwable $th) {
                //     return  "No se pudo crear el usuari de la DB";
                // }
            }
            
            
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'Estas credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }
}
