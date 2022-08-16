<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class RolController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index']]);
         $this->middleware('permission:CREAR-ROL', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {  
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $roles = Role::orderBy('name', 'asc')->simplePaginate(10);
            return view('Coordinacion.Informatica.GestionUsuarios.roles.index',compact('roles'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $name = strtoupper($name);
            $roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->simplePaginate(10);
            //$roles = Role::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('name', 'asc')->simplePaginate(10); 
            return view('Coordinacion.Informatica.GestionUsuarios.roles.index',compact('roles'));
        }
    }
    
    public function create(Request $request)
    {
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permission = Permission::orderBy('updated_at', 'desc')->get();
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $name = strtoupper($name);
            $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
            //$permission = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('updated_at', 'desc')->get(); 
            return view('Coordinacion.Informatica.GestionUsuarios.roles.crear',compact('permission'));
        }
        
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);
    
        $role = Role::create(['name' => strtoupper($request->input('name'))]);
        if ($request->input('permission')!='') {
            $role->syncPermissions($request->input('permission'));
        }
        
        
        return redirect()->route('roles.index')->with('mensaje','Rol'.strtoupper($request->input('name')). ' creado con éxito!.');                       
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
        $name = $request->query->get('name');
        $check = $request->query->get('check');

        if ($name =='') {

            if ($check == 1) {
                $check = 1;
                $role = Role::find($id);
                $permission = Permission::orderBy('updated_at', 'desc')->get();
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
                
                return view('Coordinacion.Informatica.GestionUsuarios.roles.editar',compact('role','permission','rolePermissions','check'));
            } else {
                $check = 2;
                $role = Role::find($id);
                $permission = Permission::orderBy('updated_at', 'desc')->get();
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all();
                
                return view('Coordinacion.Informatica.GestionUsuarios.roles.editar',compact('role','permission','rolePermissions','check'));
            }
            
        } else {

            $name = strtoupper($name);

            if ($check == 1) {
                $check = 1;

                $role = Role::find($id);
                $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();

                //$permission = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('updated_at', 'desc')->get();
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all(); 
            
                return view('Coordinacion.Informatica.GestionUsuarios.roles.editar',compact('role','permission','rolePermissions','check'));
            } else {
                $check=2;
                $role = Role::find($id);

                $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
                //$permission = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('updated_at', 'desc')->get();
                $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                ->all(); 
            
                return view('Coordinacion.Informatica.GestionUsuarios.roles.editar',compact('role','permission','rolePermissions','check'));    
            }

        }
/*
        if ($check == 1) {
            $role = Role::find($id);
            $permission = Permission::orderBy('updated_at', 'DESC')->paginate(1);
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
            
        }else{
            $role = Role::find($id);
            $permission = Permission::orderBy('updated_at', 'DESC')->paginate(2);
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
            
        }*/
    
        return view('Coordinacion.Informatica.GestionUsuarios.roles.editar',compact('role','permission','rolePermissions'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        $role = Role::find($id);
        $role->name = strtoupper($request->input('name'));
        $role->save();
    
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index');                        
    }
    
    public function destroy($id)
    {
        //DB::table("roles")->where('id',$id)->delete();
        
        $rol = Role::findOrFail($id);

        Role::destroy($id);
        return redirect()->route('roles.index')->with('mensaje','Rol'.$rol->name.' borrado con éxito!.');    
        
    }
}
