<?php

namespace App\Http\Controllers;

use App\Models\Quique\Estadocivil;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class EstadocivilController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        /*$this->middleware('permission:ver-conceptofacturacion|crear-conceptofacturacion|editar-conceptofacturacion|borrar-conceptofacturacion', ['only' => ['index']]);
        $this->middleware('permission:crear-conceptofacturacion', ['only' => ['create','store']]);
        $this->middleware('permission:editar-conceptofacturacion', ['only' => ['edit','update']]);
        $this->middleware('permission:borrar-conceptofacturacion', ['only' => ['destroy']]);*/
    }
    
    public function index(Request $request)
    {
        $name = $request->query->get('name');

        if (!isset($name)) {
               
            //Con paginación
            $estadocivil = Estadocivil::orderBy('desestciv', 'asc')->paginate(10);
            return view('estadocivil.index',compact('estadocivil'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $estadocivil = Estadocivil::whereRaw('UPPER(desestciv) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('desestciv', 'asc')->paginate(10);
            return view('estadocivil.index',compact('estadocivil'));
        }
    }

    
    public function create(Request $request)
    {
        return view('estadocivil.crear');   
    }
    
    public function index2(){

    }
}
