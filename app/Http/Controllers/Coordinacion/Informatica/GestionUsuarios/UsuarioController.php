<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

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
    }
    
    public function index(Request $request)
    {      
        //Sin paginación
        /* $usuarios = User::all();
        return view('usuarios.index',compact('usuarios')); */

        //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $usuarios->links() !!}
        $name = $request->query->get('name');
        
        $roles_permisos = DB::table('diegoz.roles')
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.name')
                    ->distinct('name')
                    ->get();
        $roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                    ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.name')
                    ->whereNull('diegoz.role_has_permissions.role_id')
                    ->distinct('name')
                    ->get();

        if ($name =='') {
            //Con paginación
            $usuarios = User::orderBy('id', 'desc')->simplePaginate(10);
            
            return view('Coordinacion.Informatica.GestionUsuarios.usuarios.index',compact('usuarios','roles_permisos','roles_sinpermisos'));
            
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            
            $usuarios = User::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('id', 'desc')->simplePaginate(10); 
           
            return view('Coordinacion.Informatica.GestionUsuarios.usuarios.index',compact('usuarios','roles_permisos','roles_sinpermisos'));
        }
    }
    
    public function create(Request $request)
    {
        //aqui trabajamos con name de las tablas de users

        $permisos = Permission::orderBy('name', 'asc')->get();
        
        $roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.role_has_permissions.role_id')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();

            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return view('Coordinacion.Informatica.GestionUsuarios.usuarios.crear',compact('roles','permisos','roles_sinpermisos'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
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
                $user->assignRole($request->input('grupos'));
        }
    
        return redirect()->route('usuarios.index')->with('mensaje','Usuario '.$user->email.' creado con éxito!.');
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
        //$id =  Crypt::decrypt($id);
        $user = User::find($id);

        $permisos = Permission::orderBy('name', 'asc')->get();

        
            //Con paginación
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
            $userRoles = DB::table('diegoz.users')
                        ->join('diegoz.model_has_roles', 'diegoz.model_has_roles.model_id', '=', 'diegoz.users.id')
                        ->join('diegoz.roles', 'diegoz.model_has_roles.role_id', '=', 'diegoz.roles.id')
                        ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                        ->select('diegoz.roles.*')
                        ->where('diegoz.users.id','=',$id)
                        ->distinct('diegoz.roles.name')
                        ->orderBy('diegoz.roles.name', 'asc')
                        ->get();
            
            $userGrupo = DB::table('diegoz.users')
                        ->join('diegoz.model_has_roles', 'diegoz.model_has_roles.model_id', '=', 'diegoz.users.id')
                        ->join('diegoz.roles', 'diegoz.model_has_roles.role_id', '=', 'diegoz.roles.id')
                        ->leftJoin('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                        ->select('diegoz.roles.*')
                        ->whereNull('diegoz.role_has_permissions.role_id')
                        ->where('diegoz.users.id','=',$id)
                        ->orderBy('diegoz.roles.name', 'asc')
                        ->get();
            $userPermisos=$user->permissions;
            
            $roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.role_has_permissions.role_id')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();
        
            return view('Coordinacion.Informatica.GestionUsuarios.usuarios.editar',compact('user','roles','userRoles','permisos','roles_sinpermisos','userPermisos','userGrupo'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
    }
    

    public function update(Request $request, $id)
    {
        //$id =  Crypt::decrypt($id);
        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
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
            //foreach ($request->input('roles') as $key => $value) {
            //}
                $user->assignRole($request->input('roles'));
        }
        if (is_array($request->input('permisos')) || is_object($request->input('permisos')))
        {
                $user->syncPermissions($request->input('permisos'));
        }
        if (is_array($request->input('grupos')) || is_object($request->input('grupos')))
        {
                //DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                $user->assignRole($request->input('grupos'));
        }
        
        
        //DB::table('model_has_roles')->where('model_id',$id)->delete();
        
        return redirect()->route('usuarios.index')->with('mensaje',$user->name.' editado exitosamente.');
    }
    
    public function destroy($id)
    {
        $id =  Crypt::decrypt($id);
        User::find($id)->delete();
        return redirect()->route('usuarios.index')->with('mensaje','Borrado exitosamente.');
    }

    public function pdf()
    {
        // alternativamente con:
        $pdf = app('dompdf.wrapper');
        
        //Contenido para imprimir
        //$pdf->loadHTML('<h1>Styde.net</h1>');
        $usuarios = User::orderBy('id', 'desc')->simplePaginate(10); 
        
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
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
        } else {
            
            $name = strtoupper($name);
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
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
            $roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.role_has_permissions.role_id')
                ->distinct('name')
                ->orderBy('name', 'asc')
                ->get();
        } else {
            
            $name = strtoupper($name);
            $roles_sinpermisos = DB::table('diegoz.role_has_permissions')
                ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                ->select('diegoz.roles.*')
                ->whereNull('diegoz.role_has_permissions.role_id')
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
                    ->join('diegoz.role_has_permissions', 'diegoz.roles.id', '=', 'diegoz.role_has_permissions.role_id')
                    ->join('diegoz.permissions', 'diegoz.permissions.id', '=', 'diegoz.role_has_permissions.permission_id')
                    ->select('diegoz.permissions.*')
                    ->where('diegoz.role_has_permissions.role_id','=',$id)
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
            $permisos = Permission::orderBy('name', 'asc')->get();
        } else {
            $name = strtoupper($name);
            $permisos = Permission::where('name', 'like', '%'.$name.'%')->orderBy('name', 'asc')->get();
        }
        //Role::where('airline_id', '')->orderBy('name', 'asc')->paginate(5);
        return $permisos;

    }
}
