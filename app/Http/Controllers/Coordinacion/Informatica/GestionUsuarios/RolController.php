<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
//agregamos 
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Diegoz\MenuM;
use App\Models\Diegoz\Grant_vista;
use App\Models\Diegoz\Grant_rolesxpermisos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;


class RolController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarrol']]);
         $this->middleware('permission:CREAR-ROL', ['only' => ['create','store','creargrupo','guardargrupo','storegrupoNuevo']]);
         $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','storegrupoEdit','storegrupo']]);
         $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy','eliminarmenu']]);
         $this->middleware('permission:VER-USUARIO', ['only' => ['buscarvista','creargrupo','buscarordengrupo','buscarmenus','buscarmenu','vistas','editarmenu']]);

    }

    public function index(Request $request)
    {  
        $name = $request->query->get('name');

        if ($name =='') {
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
                    
            $roles_sinpermisos = DB::table('diegoz.grant_rolesxpermisos')
                    ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->where('name','like','%' .$name . '%')
                    ->whereNull('diegoz.grant_rolesxpermisos.role_id')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
            return view('Coordinacion.Informatica.GestionUsuarios.roles.index',compact('roles','roles_sinpermisos'));
        } else {
            $name = strtoupper($name);
            $roles = DB::table('diegoz.roles')
                    ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->where('name','like','%' .$name . '%')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
            $roles_sinpermisos = DB::table('diegoz.grant_rolesxpermisos')
                    ->rightJoin('diegoz.roles', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
                    ->select('diegoz.roles.*')
                    ->where('name','like','%' .$name . '%')
                    ->whereNull('diegoz.grant_rolesxpermisos.role_id')
                    ->distinct('name')
                    ->orderBy('name', 'asc')
                    ->get();
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->simplePaginate(10);
            //$roles = Role::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('name', 'asc')->simplePaginate(10); 
            return view('Coordinacion.Informatica.GestionUsuarios.roles.index',compact('roles','roles_sinpermisos'));
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
            'permission' => 'required',
        ]);
    
        $role = Role::create(['name' => strtoupper($request->input('name'))]);
        if ($request->input('permission')!='') {
            
            foreach ($request->input('permission') as $valor) {
                
                $permiso = Permission::find($valor);
                $model = new Grant_rolesxpermisos;
                $model->permission_id = $permiso->id;
                $model->role_id = $role->id;
                $model->save();
                
            }

        }
        return redirect()->route('roles.index')->with('mensaje','Rol '.strtoupper($request->input('name')). ' creado con éxito!.');                       
    }
    
    public function show($id)
    {
    }
    
    public function edit(Request $request, $id)
    {
        $name = $request->query->get('name');

        if ($name =='') {
            $role = Role::find($id);
            $permission = Permission::orderBy('updated_at', 'desc')->get();
            $rolePermissions = DB::table("grant_rolesxpermisos")->where("grant_rolesxpermisos.role_id",$id)
            ->pluck('grant_rolesxpermisos.permission_id','grant_rolesxpermisos.permission_id')
            ->all();            
        } else {
            $name = strtoupper($name);
            $role = Role::find($id);
            $permission = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->get();
            $rolePermissions = DB::table("grant_rolesxpermisos")->where("grant_rolesxpermisos.role_id",$id)
            ->pluck('grant_rolesxpermisos.permission_id','grant_rolesxpermisos.permission_id')
            ->all(); 
        }    
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
    
        DB::table('grant_rolesxpermisos')->where('role_id',$role->id)->delete();

        if ($request->input('permission')!='') {
            
            foreach ($request->input('permission') as $valor) {
                
                $permiso = Permission::find($valor);
                $model = new Grant_rolesxpermisos;
                $model->permission_id = $permiso->id;
                $model->role_id = $role->id;
                $model->save();
                
            }

        }
    
        return redirect()->route('roles.index');                        
    }
    
    public function destroy($id)
    {
        //DB::table("roles")->where('id',$id)->delete();
        
        $rol = Role::findOrFail($id);

        Role::destroy($id);
        return redirect()->route('roles.index')->with('mensaje','Rol'.$rol->name.' borrado con éxito!.');    
        
    }
    public function creargrupo(Request $request)
    {
        $arbol=MenuM::menus(2);
        $listamenus= MenuM::where('tipo','!=' , 0)->orderBy('idmenu', 'asc')->get();
        $permisos = Permission::where('CLASE','=','1')->orderBy('name', 'asc')->get();
        $roles = DB::table('diegoz.roles')
        ->join('diegoz.grant_rolesxpermisos', 'diegoz.roles.id', '=', 'diegoz.grant_rolesxpermisos.role_id')
        ->select('diegoz.roles.*')
        ->distinct('name')
        ->orderBy('name', 'asc')
        ->get();
        return view('Coordinacion.Informatica.GestionUsuarios.roles.creargrupo',compact('arbol','listamenus','permisos','roles'));
    }

    public function guardargrupo(Request $request)  
    {
        //return $request->input('idpadre').$request->input('nombre').'3';
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:roles,name',
            'idpadre' => 'required|min:0|max:9999|integer',
        ]);
        if ($validator->fails()) {
            return redirect()->route('roles.index')
                        ->withErrors($validator)
                        ->withInput();
        }
    
        $role = Role::create(['name' => strtoupper($name)]);
               
        return redirect()->route('roles.creargrupo')->with('mensaje','Grupo '.strtoupper($request->input('name')). ' creado con éxito!.');                       
    }
    
    public function buscarordengrupo(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        
        $id = $request->input("id");

        $orden= MenuM::where('idmenupadre',$id)->orderBy('orden', 'asc')->get();
        return $orden;
        
    }
    public function buscarmenus(Request $request)  
    {
        $vista= Grant_vista::orderBy('nomvista', 'asc')->get();
        return $vista;
        
    }
    public function buscarmenu(Request $request) 
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $id = $request->input("id");

        $menupadre= MenuM::find($id);
        $orden= MenuM::where('idmenupadre',$id)->orderBy('idmenupadre', 'asc')->get();
        return compact('menupadre','orden');
    }

    public function storegrupoNuevo(Request $request){ 
        
        $this->validate($request, [
            'name' => 'required|string',
            'idmenupadre'=>'required|numeric',
            'orden'=>'required|numeric',
            'visible'=>'required|numeric',
            'menuhoja'=>'required|numeric',
        ]);
    
        $bandera=false;
        $menu2 = new MenuM;
        $data = MenuM::latest('idmenu')->first();
        $menu2->idmenu = $data['idmenu'] + 1;
        $menu2->nommenu = strtoupper($request->input('name'));

        $padre = MenuM::findOrFail($request->input('idmenupadre'));
        $menu2->idmenupadre = $request->input('idmenupadre');
        $menu2->orden = $request->input('orden');
        $menu2->visible = $request->input('visible');
        if ($request->input('menuhoja')==0) {
            $menu2->tipo = 0;
            $this->validate($request, [
                'nomvista'=>'required|string',
                'path'=>'required|string',
                'nomarchivo'=>'required|string',
                'rol-permiso-automatico'=>'required|numeric',
            ]);
            $vista = Grant_vista::where('nomvista','=',strtoupper($request->input('nomvista')))->first();
            if ($vista === null) {
                $bandera=true;
                $vista = new Grant_vista;
                //$data2 = DB::table('diegoz.Grant_vista')->get();
                $data2 = Grant_vista::latest('idvista')->first();
                $vista->idvista = $data2['idvista'] + 1;
                $vista->nomvista = strtoupper($request->input('nomvista'));
                $vista->path = strtoupper($request->input('path'));
                $vista->nomarchivo = strtoupper($request->input('nomarchivo'));
            }
                if ($request->input('rol-permiso-automatico')==0) {
                    $this->validate($request, [
                        'permiso'=>'required|numeric',
                        'roless'=>'required|numeric',
                    ]);
                    $permiso = Permission::find($request->input('permiso'));
                    $rol = Role::find($request->input('roless'));
                } else {
                    $rol = Role::where('name','=',$vista->nomvista)->first();
                    if (count((array)$rol) > 0) {
                        return redirect()->route('roles.index')->with('alerta','No se pudo crear el Rol  '.$vista->nomvista.' para la asignacion porque ya existe!.');       
                    }
                    
                    $separador = explode('.', $vista->nomvista);
                    $permiso = Permission::firstOrCreate(['name' => 'VER-'.$separador[0]]);
                    $permiso2 = Permission::firstOrCreate(['name' => 'BORRAR-'.$separador[0]]);
                    $permiso3 = Permission::firstOrCreate(['name' => 'CREAR-'.$separador[0]]);
                    $permiso4 = Permission::firstOrCreate(['name' => 'EDITAR-'.$separador[0]]);

                    

                    $rol = Role::create(['name' => strtoupper($separador[0])]);
                    
                    $user = User::where('email','admin@gmail.com')->first();
                    $user->assignRole($rol->id);

                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso->id;
                    $user->givePermissionTo($permiso->id);
                    $model->role_id = $rol->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso2->id;
                    $user->givePermissionTo($permiso2->id);
                    $model->role_id = $rol->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso3->id;
                    $user->givePermissionTo($permiso3->id);
                    $model->role_id = $rol->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso4->id;
                    $user->givePermissionTo($permiso4->id);
                    $model->role_id = $rol->id;
                    $model->save();
                    $role = Role::where('name','ADMIN')->first();

                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso->id;
                    $model->role_id = $role->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso2->id;
                    $model->role_id = $role->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso3->id;
                    $model->role_id = $role->id;
                    $model->save();
                    $model = new Grant_rolesxpermisos;
                    $model->permission_id = $permiso4->id;
                    $model->role_id = $role->id;
                    $model->save();
                }
        }else{
            $this->validate($request, [
                'name' => 'unique:roles,name',
            ]);
            $menu2->tipo = $padre->tipo +1;
        }
        $menus = MenuM::where('idMenuPadre','=',$menu2->idmenupadre)->where('orden','>=',$menu2->orden)->orderBy('orden','asc')->get();
        foreach ($menus as $elemento) {
            $m = MenuM::find($elemento->idmenu);
            $m->orden = $m->orden + 1;
            $m->save();
        }
        if ($request->input('menuhoja')==0) {
            if ($bandera) {
                $vista->rol = $rol->id;
                $vista->save();
                $menu2->idvista = $vista->idvista;
                $menu2->save();
                
                DB::table('diegoz.grant_menuxpermisos')->insert([
                    'idpermiso' => $permiso->id,
                    'idmenu' => $menu2->idmenu
                ]);
                return redirect()->route('roles.index')->with('mensaje','Hoja '.$menu2->nommenu. ' creada con éxito!.');
            }
            $menu2->idvista = $vista->idvista;
            $menu2->save();
            
            DB::table('diegoz.grant_menuxpermisos')->insert([
                'idpermiso' => $permiso->id,
                'idmenu' => $menu2->idmenu
            ]);
            return redirect()->route('roles.index')->with('mensaje','Hoja '.$menu2->nommenu. ' creada con éxito!.');
        }
        if ($request->input('menuhoja')!=0) {
            $menu2->save();
            $role = Role::create(['name' => $menu2->idmenu.$menu2->nommenu]);
            
            $user = User::where('email','admin@gmail.com')->first();
            $user->assignRole($role->id);
            
            return redirect()->route('roles.index')->with('mensaje','Grupo '.$menu2->idmenu.$menu2->nommenu. ' creado con éxito!.');
        }
    }
    public function storegrupoEdit(Request $request){ 

        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'orden'=>'required|numeric',
            'visible'=>'required|numeric',
        ]);

        $data = MenuM::find($request->input('id'));


        if ($data->tipo == 0) {
            $data->nommenu = $request->input('name');
            $this->validate($request, [
                'permiso'=>'required|numeric',
            ]);

            $permiso = Permission::find($request->input('permiso'));
            DB::table('diegoz.grant_menuxpermisos')->where('idmenu','=',$request->input('id'))->delete();
            DB::table('diegoz.grant_menuxpermisos')->insert([
                'idpermiso' => $permiso->id,
                'idmenu' => $request->input('id')
            ]);

        } else {
            if ($request->input('name') != $data->nommenu) {
                $rol = Role::where('name',$request->input('id').$data->nommenu)->first();
                $rol->name = $request->input('id').$request->input('name');
                $rol->save();
                $data->nommenu = $request->input('name');
            }
        }

        if ($request->input('orden') != $data->orden) {
            $menus = MenuM::where('idMenuPadre','=',$data->idmenupadre)->where('orden','>',$data->orden)->orderBy('orden','asc')->get();
            foreach ($menus as $elemento) {
                $m = MenuM::find($elemento->idmenu);
                $m->orden = $m->orden - 1;
                $m->save();
            }
            $menus = MenuM::where('idMenuPadre','=',$data->idmenupadre)->where('orden','>=',$request->input('orden'))->orderBy('orden','asc')->get();
            foreach ($menus as $elemento) {
                $m = MenuM::find($elemento->idmenu);
                $m->orden = $m->orden + 1;
                $m->save();
            }
            $data->orden = $request->input('orden');
        }
        $data->visible = $request->input('visible');
        $data->save();
        return redirect()->route('roles.creargrupo')->with('mensaje','El Menu '.$data->nommenu.' fue editado con exito!.');
    }

    public function storegrupo(Request $request)
    {
        $this->validate($request, [
            'edit' => 'required|numeric',
        ]);

        if ($request->input('edit') == 0) {
           return $this->storegrupoNuevo($request);
        } else {
           return $this->storegrupoEdit($request);
        }
        
        
    }
    
    
    public function vistas(Request $request) 
    {
        $search = $request->search;
        if ($search != '') {
            $vistas = Grant_vista::where('nomvista', 'like', '%'.strtoupper($search).'%')->orderBy('nomvista', 'desc')->get();
        }else{
            return;
        }
        $response = array();
        foreach ($vistas as $vista) {
            $response[] = array(
                'id' => $vista->idvista,
                'text' => $vista->nomvista,
            );
        }
        return response()->json($response);
    }
    public function buscarvista(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string'
        ]);
        $nombre = $request->input("nombre");

        $vista= Grant_vista::where('nomvista',$nombre)->orderBy('nomvista', 'asc')->first();
        return compact('vista');
    }

    public function eliminarmenu(Request $request,$id)
    {
        $MenuM = MenuM::find($id);
        $hijos = MenuM::where('idMenuPadre','=',$id)->first();
        if (count((array)$hijos) > 0) {
            return redirect()->route('roles.creargrupo')->with('alerta','El Menu '.$MenuM->nommenu.' tiene hijos asociados!.');
        }
        $menus = MenuM::where('idMenuPadre','=',$MenuM->idmenupadre)->where('orden','>=',$MenuM->orden)->orderBy('orden','asc')->get();
        foreach ($menus as $elemento) {
            $m = MenuM::find($elemento->idmenu);
            $m->orden = $m->orden - 1;
            $m->save();
        }
        if ($MenuM->tipo == 0) {
            DB::table('diegoz.grant_menuxpermisos')->where('idmenu', '=', $id)->delete();
        } else {
            Role::where('name',$MenuM->idmenu.$MenuM->nommenu)->delete();
        }
        $MenuM->delete();
        return redirect()->route('roles.creargrupo')->with('mensaje','Menu '.$MenuM->nommenu.' borrado con éxito!.');
    }
    public function editarmenu(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $id = $request->input("id");

        $MenuM = MenuM::find($id);
        $Grant_vista=[];
        $rol=[];
        $permiso=[];
        if ($MenuM->tipo == 0) {
            $idpermiso = DB::table('diegoz.grant_menuxpermisos')->where('idmenu', '=', $MenuM->idmenu)->first();
            $permiso = Permission::find($idpermiso->idpermiso);
            $Grant_vista = Grant_vista::find($MenuM->idvista);
            $rol = Role::find($Grant_vista->rol);
        } 
        return compact('MenuM','Grant_vista','rol','permiso');
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
    public function buscarrol(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $id = $request->input("id");

        $rol = Role::find($id);

        return compact('rol');

    }
    
}
