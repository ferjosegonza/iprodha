<?php

namespace App\Http\Controllers;

use App\Models\System\Iprousuario;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IprousuarioController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-IPROUSUARIO|CREAR-IPROUSUARIO|EDITAR-IPROUSUARIO|BORRAR-IPROUSUARIO', ['only' => ['index']]);
        $this->middleware('permission:CREAR-IPROUSUARIO', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-IPROUSUARIO', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-IPROUSUARIO', ['only' => ['destroy']]);
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
            $iprousuarios = Iprousuario::orderBy('nomcom', 'asc')->simplePaginate(10);
            return view('iprousuarios.index',compact('iprousuarios'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $iprousuarios = Iprousuario::whereRaw('UPPER(nomcom) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('nomcom', 'asc')->simplePaginate(10);
            return view('iprousuarios.index',compact('iprousuarios'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        //return view('iprousuarios.crear');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return redirect()->route('iprousuarios.index')->with('mensaje','Usuario creado con éxito!.');
        /*

        $this->validate($request, [
            'name' => 'required|unique:modelos,name',
        ]);

        $input = $request->all();
        Modelo::create(['name' => $request->input('name')]);
        
        
    
        return redirect()->route('modelo.index')->with('mensaje','Modelo creado con éxito!.');*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iprousuario  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show( )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iprousuario  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit( $nomcom)
    {
        //$iprousuario = Iprousuario::where('nomcom',$nomcom);
       // return view('iprousuarios.editar',compact('iprousuario'));
        /*
                $modelo = Modelo::find($id);
                return view('modelo.editar',compact('modelo'));
            */

    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return redirect()->route('iprousuarios.index')->with('mensaje','Usuario editado con éxito!.');
        
        /*
        $this->validate($request, [
            'name' => 'required|unique:modelos,name',
        ]);
    
        $modelo = Modelo::find($id);
        $modelo->name = $request->input('name');
        $modelo->save();
    
    
        return redirect()->route('modelo.index')->with('mensaje','Modelo editado con éxito!.');   */                     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iprousuario  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // return redirect()->route('iprousuarios.index')->with('mensaje','Usuario borrado con éxito!.');
        
        //DB::table("roles")->where('id',$id)->delete();
        
        /*
        $modelo = Modelo::findOrFail($id);

        Modelo::destroy($id);
        return redirect()->route('modelo.index')->with('mensaje','Modelo borrado con éxito!.'); */   
        
    }
}
