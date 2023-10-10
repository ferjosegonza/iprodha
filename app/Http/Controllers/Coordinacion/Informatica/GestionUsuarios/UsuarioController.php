<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Models\User;
use App\Models\Diegoz\MenuM;
use App\Models\Iprodha\Fav_Favorito;
use App\Models\Iprodha\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use \PDF;


class UsuarioController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-USUARIO|CREAR-USUARIO|EDITAR-USUARIO|BORRAR-USUARIO', ['only' => ['index']]);
        $this->middleware('permission:CREAR-USUARIO', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-USUARIO', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-USUARIO', ['only' => ['destroy']]);
        $this->middleware('permission:VER-USUARIO', ['only' => ['buscarpermisos','buscarpermisosdelrol','listarrolessinpremisos','listarrolesconpremisos','pdf']]);
        
    }
    
    public function index(Request $request)
    {      
        $name = $request->query->get('name');
        
        $roles_permisos = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.name')
                    ->distinct('name')
                    ->get();
        /*$roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                    ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.name')
                    ->whereNull('diegoz.role_has_permissions.role_id')
                    ->distinct('name')
                    ->get();*/

        if ($name =='') {
            $usuarios = User::orderBy('id', 'desc')->get();
        } else {
            $usuarios = User::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('id', 'desc')->get(); 
        }
        return view('Coordinacion.Informatica.GestionUsuarios.usuarios.index',compact('usuarios','roles_permisos'));

    }
    
    public function create(Request $request)
    {
        $permisos = Permission::where('CLASE','=','1')->orderBy('name', 'asc')->get();
        
        $roles_sinpermisos = DB::table('diegoz.grant_rolesxpermisos')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.grant_rolesxpermisos.role_id')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();

        $roles = DB::table('diegoz.roles')
                ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                ->select('diegoz.roles.*')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();
        
        $arbol = MenuM::menus(1);

        return view('Coordinacion.Informatica.GestionUsuarios.usuarios.crear',compact('arbol','roles','permisos','roles_sinpermisos'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'emailnew' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['email'] = $input['emailnew'];

        $user = User::create($input);
        if (is_array($request->input('roles')) || is_object($request->input('roles')))
        {
            $user->assignRole($request->input('roles'));
        }
        if (is_array($request->input('permisos')) || is_object($request->input('permisos')))
        {
            $user->syncPermissions($request->input('permisos'));
        }
        if (is_array($request->input('grupos')) || is_object($request->input('grupos')))
        {
            foreach ($request->input('grupos') as $valor) {
                $grupo = MenuM::find($valor);
                $name=$grupo->idmenu.$grupo->nommenu;
                $rol = Role::where('name', '=',$name)->first();
                $user->assignRole($rol->id);
            }

        }
        return redirect()->route('usuarios.index')->with('mensaje','Usuario '.$user->email.' creado con éxito!.');
    }
    
    public function show($id)
    {
        return 1;
    }
    
    public function edit(Request $request, $id)
    {
        //$id =  Crypt::decrypt($id);
        $user = User::find($id);
        $user->emailnew = $user->email;

        $permisos = Permission::where('CLASE','=','1')->orderBy('name', 'asc')->get();

        
        $roles = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
        $userRoles = DB::table('diegoz.users')
                        ->join('diegoz.model_has_roles', 'diegoz.model_has_roles.model_id', '=', 'diegoz.users.id')
                        ->join('diegoz.roles', 'diegoz.model_has_roles.role_id', '=', 'diegoz.roles.id')
                        ->join('diegoz.Grant_RolesXPermisos', 'diegoz.roles.id', '=', 'diegoz.Grant_RolesXPermisos.role_id')
                        ->select('diegoz.roles.*')
                        ->where('diegoz.users.id','=',$id)
                        ->distinct('diegoz.roles.name')
                        ->orderBy('diegoz.roles.name', 'asc')
                        ->get();
            
        $userGrupo = DB::table('diegoz.users')
                            ->join('diegoz.model_has_roles', 'diegoz.model_has_roles.model_id', '=', 'diegoz.users.id')
                            ->join('diegoz.roles', 'diegoz.model_has_roles.role_id', '=', 'diegoz.roles.id')
                            ->leftJoin('diegoz.Grant_RolesXPermisos', 'diegoz.roles.id', '=', 'diegoz.Grant_RolesXPermisos.role_id')
                            ->select('diegoz.roles.*')
                            ->whereNull('diegoz.Grant_RolesXPermisos.role_id')
                            ->where('diegoz.users.id','=',$id)
                            ->orderBy('diegoz.roles.name', 'asc')
                            ->get();
        
        $userPermisos=$user->permissions;
                
        $roles_sinpermisos = DB::table('diegoz.Grant_RolesXPermisos')
                    ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.Grant_RolesXPermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->whereNull('diegoz.Grant_RolesXPermisos.role_id')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
                
        $Empresa= Empresa::orderBy('nom_emp')->get();

        $arbol = MenuM::menus(2);
        return view('Coordinacion.Informatica.GestionUsuarios.usuarios.editar',compact('arbol','user','roles','userRoles','permisos','roles_sinpermisos','userPermisos','userGrupo', 'Empresa'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
    }
    

    public function update(Request $request, $id)
    {
        //$id =  Crypt::decrypt($id);
        
        $this->validate($request, [
            'name' => 'required',
            'emailnew' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);


        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        DB::table('model_has_permissions')->where('model_id',$user->id)->delete();


        if (is_array($request->input('roles')) || is_object($request->input('roles')))
        {
            $user->assignRole($request->input('roles'));
        }
        if (is_array($request->input('permisos')) || is_object($request->input('permisos')))
        {
            $user->syncPermissions($request->input('permisos'));
        }
        if (is_array($request->input('grupos')) || is_object($request->input('grupos')))
        {
            foreach ($request->input('grupos') as $valor) {
                $grupo = MenuM::find($valor);
                $name=$grupo->idmenu.$grupo->nommenu;
                $rol = Role::where('name', '=',$name)->first();
                $user->assignRole($rol->id);

            }
        }
        
        if($request->input('idempresa')){
            $empresaOld = Empresa::where('iduserweb', $user->id)->first();

            if(!is_null($empresaOld)){
                $empresaOld->update([
                    'iduserweb' => null
                ]);
            }      
            
            $empresa = Empresa::find($request->input('idempresa'));
            
            $empresa->update([
                'iduserweb' => $user->id
            ]);
        }
        
        //DB::table('model_has_roles')->where('model_id',$id)->delete();
        
        return redirect()->route('usuarios.index')->with('mensaje',$user->name.' editado exitosamente.');
    }
    
    public function destroy($id)
    {
        $id =  Crypt::decrypt($id);
        Fav_Favorito::where('idusuario', '=', $id)->delete();
        User::find($id)->delete();
        return redirect()->route('usuarios.index')->with('mensaje','Borrado exitosamente.');
    }

    public function pdf()
    {
        // alternativamente con:
        $pdf = app('dompdf.wrapper');
        
        //Contenido para imprimir
        //$pdf->loadHTML('<h1>Styde.net</h1>');
        $usuarios = User::orderBy('id', 'desc')->get(); 
        
        $pdf->loadView('Coordinacion.Informatica.GestionUsuarios.usuarios.pdf',['usuarios'=>$usuarios]);
        //$pdf = PDF::loadView('usuarios.pdf',['usuarios'=>$usuarios]);
        
        $pdf->setPaper('a5', 'landscape');     //dar vuelta la hoja 
        $pdf->setOptions(['font' => 'Symbol']);
        
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'symbol']);

        return $pdf->stream('mi-archivo.pdf');

        //$pdf->setOptions(['helvetica','default_paper_size' => 'a0']);

        $pdf->setPaper('sra0');
        //$pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }

    public function listarrolesconpremisos(Request $request)
    {
        $name = $request->input("name2");

        if ($name =='') {
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
        } else {
            
            $name = strtoupper($name);
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->where('diegoz.roles.name', 'like', '%'.$name.'%')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
        }
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $roles;

    }
    public function listarrolessinpremisos(Request $request)
    {
        $name = $request->input("name4");

        if ($name =='') {
            $roles_sinpermisos = DB::table('diegoz.grant_rolesxpermisos')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.grant_rolesxpermisos.role_id')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            
            $name = strtoupper($name);
            $roles_sinpermisos = DB::table('diegoz.grant_rolesxpermisos')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.grant_rolesxpermisos.role_id')
                ->where('diegoz.roles.name', 'like', '%'.$name.'%')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();
        }
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $roles_sinpermisos;

    }
    public function buscarpermisosdelrol(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        
        $id = $request->input("id");


        $rol = Role::find($id);
        $permisos = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->join('diegoz.permissions', 'diegoz.permissions.id', '=', 'diegoz.grant_rolesxpermisos.permission_id')
                    ->select('diegoz.permissions.*')
                    ->where('diegoz.grant_rolesxpermisos.role_id','=',$id)
                    ->distinct('diegoz.permissions.name')
                    ->orderBy('diegoz.permissions.name', 'asc')
                    ->get();
        
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $permisos;

    }
    public function buscarpermisos(Request $request)
    {
        
        $name = $request->input("name3");

        if ($name =='') {
            $permisos = Permission::where('CLASE','=','1')->orderBy('name', 'asc')->get();
        } else {
            $name = strtoupper($name);
            $permisos = Permission::where('name', 'like', '%'.$name.'%')->orderBy('name', 'asc')->get();
        }
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $permisos;

    }


}
