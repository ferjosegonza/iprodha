<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//agregamos
use App\Models\Silverol\CategoriaLaboral;
use \PDF;


class PermisopruebaController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-CATEGORIALABORAL|CREAR-CATEGORIALABORAL|EDITAR-CATEGORIALABORAL|BORRAR-CATEGORIALABORAL', ['only' => ['index']]);
         $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {        
        // $name = $request->query->get('name');
        // if (!isset($name)) {
               
        //     //Con paginación
        //     $CategoriasLaborales = CategoriaLaboral::orderBy('id_catlaboral', 'asc')->simplePaginate(10);
        //     //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        // } else {
        //     //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
        //     $CategoriasLaborales = CategoriaLaboral::whereRaw('UPPER(catlaboral) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('id_catlaboral', 'asc')->paginate(10);
        // }

        //return view('permisoprueba.index',compact('CategoriasLaborales'));
        return view('permisoprueba.index');
    }
    
    public function create(Request $request)
    {
       
    }

    public function store(Request $request)
    {
                          
    }

    public function show($id)
    {
        
    }

   
    public function edit(Request $request, $id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
                                                  
    }

    public function destroy($id)
    {
            
        
    }

}
