<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//agregamos
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermisoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
         $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permisos = Permission::orderBy('name', 'asc')->simplePaginate(10);
            return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            
            $name = strtoupper($name);
            $permisos = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->simplePaginate(10);
            
            //$permisos = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('name', 'asc')->simplePaginate(10); 
            return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
        }
    }
    
    public function buscarPermisos(Request $request)
    {        
         //Con paginación
         $permisos = Permission::paginate(50);
         return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!} 
    }

    public function create()
    {
        return view('Coordinacion.Informatica.GestionUsuarios.permisos.crear');
    }

    public function store(Request $request)
    {
        $campos = [
            'name' => 'required|string|max:189',
            
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido'
        ];

        $this->validate($request,$campos,$mensaje);

        $name = $request->input('name');
        $name = strtoupper($name);

        $permiso =  Permission::create(['name'=>$name]); 

        $role = Role::where('name','ADMIN')->get();
        $permiso->assignRole($role);
    
        return redirect()->route('permisos.create')->with('mensaje',$name.' creado exitosamente.');                       
    }
    
    public function show($id)
    {
    }
    
    public function edit($id)
    {
        $permiso = Permission::findOrFail($id);
    
        return view('Coordinacion.Informatica.GestionUsuarios.permisos.editar',compact('permiso'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        $permiso = Permission::find($id);
        $permiso->name = strtoupper($request->input('name'));
        $permiso->save();
    
        return redirect()->route('permisos.index')->with('mensaje',$permiso->name.' editado exitosamente.');                        
    }
    
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);
        return redirect()->route('permisos.index');               
    }
}
