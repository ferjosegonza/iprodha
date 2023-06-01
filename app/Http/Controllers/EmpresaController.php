<?php

namespace App\Http\Controllers;

use App\Models\Iprodha\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    function __construct()
    {
        // $this->middleware('auth');
        //  $this->middleware('permission:VER-ALUMNOS|CREAR-ALUMNOS|EDITAR-ALUMNOS|BORRAR-ALUMNOS', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-ALUMNOS', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-ALUMNOS', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-ALUMNOS', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
    }

    
    public function create()
    {
    }

    
    public function store(Request $request)
    {
  
    }

    
    public function show(Alumno $alumno)
    {
        //
    }

    
    public function edit(Request $request, $dni)
    {
    
    }

    
    public function update(Request $request, $dni)
    {
                
    }

    
    public function destroy($dni)
    {
        
    }

    public function buscarEmpresa(Request $request)
    {
    	$empresas = [];

        if($request->has('q')){
            $search = $request->q;
            $movies =Empresa::select("id_emp", "nom_emp")
            		->where('name', 'LIKE', "%$search%")
            		->get();
        }
        return response()->json($movies);
    }
}