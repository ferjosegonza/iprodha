<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos
use App\Models\Silverol\Ticket;
use \PDF;


class TicketController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        /* $this->middleware('permission:VER-PERMISO|CREAR-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO', ['only' => ['index']]);
         $this->middleware('permission:CREAR-PERMISO', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-PERMISO', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-PERMISO', ['only' => ['destroy']]);*/

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

        // return view('categorialaboral.index',compact('CategoriasLaborales'));
        return view('ticket.index');
    }
    
    public function create(Request $request)
    {
        return view('ticket.crear');
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
