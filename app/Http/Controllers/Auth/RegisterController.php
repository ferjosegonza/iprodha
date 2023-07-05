<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Iprodha\Fav_Favorito;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Diegoz\MenuM;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;
use App\Models\Iprodha\Lav_user_db;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if($data['emp'] == 1){
            $grupo = MenuM::find(42);
            $name = $grupo->idmenu.$grupo->nommenu;
            $rol = Role::where('name', '=',$name)->first();
            $user->assignRole($rol->id);
            $user->syncPermissions(['CREAR-TICKET', 'EDITAR-TICKET', 'VER-ARCHIVOS', 'VER-TICKET']);

            //Creacion de atajo a ticket
            Fav_Favorito::create(['idusuario' => $user->id , 'ruta' => 'ticket.index', 'titulo' => 'Ticket para el Soporte Informático', 'descripcion' => 'Generar tickets para soporte informático.']);
            //Creacion de atajo a documentacion digital
            Fav_Favorito::create(['idusuario' => $user->id , 'ruta' => 'archivos.consultar', 'titulo' => 'Búsqueda de Archivos Digitalizados', 'descripcion' => 'Busqueda de archivos que se encuentras digitalizados.']);
        }
        
        $userWeb = "WEB-".$user->id;
        $pass = $data['password'];

        $creaUserDB = 'CREATE USER "'.$userWeb.'" PROFILE DEFAULT IDENTIFIED BY "'.$pass.'" DEFAULT TABLESPACE USERS ACCOUNT UNLOCK';
        // DB::select(DB::raw($creaUserDB));
        DB::statement($creaUserDB);
        $permisoUserDB = 'GRANT CONNECT,RESOURCE,TABLAVIEJA,TABLANUEVA,TABLAGENERAL TO "'.$userWeb.'"';
        // DB::select(DB::raw($permisoUserDB));
        DB::statement($permisoUserDB);

        Lav_user_db::create([
            'id_user_lav' => $user->id,
            'pass_lav' => Crypt::encryptString($data['password']),
            'user_lav' => $userWeb,
        ]);

        $userWeb = "WEB-".$user->id;
        $pass = $data['password'];

        $creaUserDB = 'CREATE USER "'.$userWeb.'" PROFILE DEFAULT IDENTIFIED BY "'.$pass.'" DEFAULT TABLESPACE USERS ACCOUNT UNLOCK';
        // DB::select(DB::raw($creaUserDB));
        DB::statement($creaUserDB);
        $permisoUserDB = 'GRANT CONNECT,RESOURCE,TABLAVIEJA,TABLANUEVA,TABLAGENERAL TO "'.$userWeb.'"';
        // DB::select(DB::raw($permisoUserDB));
        DB::statement($permisoUserDB);

        Lav_user_db::create([
            'id_user_lav' => $user->id,
            'pass_lav' => Crypt::encryptString($data['password']),
            'user_lav' => $userWeb,
        ]);
        

        return $user;
    }
}
