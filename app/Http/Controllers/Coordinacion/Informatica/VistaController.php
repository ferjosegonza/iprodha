<?php

namespace App\Http\Controllers\Coordinacion\Informatica;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Diegoz\Grant_vista;
use App\Models\Diegoz\MenuM;





class VistaController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarvista']]);
         $this->middleware('permission:CREAR-ROL', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','updatevista']]);
         $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        

        $vistas = Grant_vista::orderby('nomvista','asc')->get();
        $arbol=MenuM::menus(0);
        return view('Coordinacion.Informatica.vistas.index',compact('vistas','arbol'));

    }
    


    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }
    public function updatevista(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'path' => 'required|string',
            'archivo' => 'required|string',
        ]);

        
        $vista = Grant_vista::findOrFail($request->input('id')); 

        $vista->nomvista = strtoupper($request->input('name'));
        $vista->path = strtoupper($request->input('path'));
        $vista->nomarchivo = strtoupper($request->input('archivo'));

        $vista->save();

        return redirect()->route('vistas.index')->with('mensaje','Vista '.$vista->nomvista.' modificada con éxito!.');
    }

    public function destroy($id)
    {              
    }
    
    public function buscarvista(Request $request)
    {       
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);

        $id = $request->query->get('id');

        $vista = Grant_vista::find($id);  
        $arbol=MenuM::menusUnaVista($vista->nomvista);
        $html = view('Coordinacion.Informatica.vistas.menu-unavista',compact('arbol'))->render();
        return compact('html','vista');
    }
}
