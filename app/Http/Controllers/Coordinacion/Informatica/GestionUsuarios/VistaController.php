<?php

namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Iprodha\Vista;




class VistaController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-VISTA|CREAR-VISTA|EDITAR-VISTA|BORRAR-VISTA', ['only' => ['index']]);
         $this->middleware('permission:CREAR-VISTA', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-VISTA', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-VISTA', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $name = $request->query->get('name');

        if ($name =='') {
            //Con paginación
            $permisos = Permission::orderBy('name', 'asc')->simplePaginate(10);
            return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$permisos = Permission::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            
            $permisos = Permission::whereRaw('UPPER(name) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('name', 'asc')->simplePaginate(10); 
            return view('Coordinacion.Informatica.GestionUsuarios.permisos.index',compact('permisos'));
        }
        
    }
    
    public function buscarPermisos(Request $request)
    {        
         //Con paginación
         $permisos = Permission::paginate(50);
         return view('Coordinacion.Informatica.permisos.index',compact('permisos'));
         //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!} 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Coordinacion.Informatica.permisos.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = [
            'name' => 'required|string|max:189',
            
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido'
        ];

        $this->validate($request,$campos,$mensaje);

        $permiso =  Permission::create(['name'=>$request->input('name')]); 

        $role = Role::where('name','Admin')->get();
        $permiso->assignRole($role);
    
        return redirect()->route('permisos.create')->with('mensaje',$request->input('name').' creado exitosamente.');                       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permiso = Permission::findOrFail($id);
    
        return view('Coordinacion.Informatica.permisos.editar',compact('permiso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        $permiso = Permission::find($id);
        $permiso->name = $request->input('name');
        $permiso->save();
    
        return redirect()->route('permisos.index')->with('mensaje',$request->input('name').' editado exitosamente.');                        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permiso = Permission::findOrFail($id);

        Permission::destroy($id);
        return redirect()->route('permisos.index');               
    }
}
