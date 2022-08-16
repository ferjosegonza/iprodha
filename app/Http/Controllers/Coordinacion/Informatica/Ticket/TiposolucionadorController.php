<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Silverol\Solucionador;
use App\Models\Silverol\TipoSolucionador;
use \PDF;


class TiposolucionadorController extends Controller
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
        // //return response()->json([Solucionador::find(1)->getTipo]);
        // //return Solucionador::find(1)->getTipo->destipsolucionador;
        // //return response()->json([TipoSolucionador::find(1)->getSolucionador()]);

        // // return ;
        // if (!isset($name)) {
               
        //     //Con paginación
        //     $Solucionadores = Solucionador::orderBy('idsolucionador', 'asc')
        //                                                             ->simplePaginate(10);
        //     //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        // } else {
        //     //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
        //     $Solucionadores = Solucionador::whereRaw('UPPER(nombre) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idsolucionador', 'asc')->paginate(10);
        // }
        $Tipos = Tiposolucionador::all();
        return view('ticket.tiposolucionador.index',compact('Tipos'));    
        return view('ticket.tiposolucionador.index');
    }
    
    public function create(Request $request)
    {
        return view('ticket.tiposolucionador.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
             'nombre' => 'required|string',
        ]);

        $input = $request->all();

        $modelo = new TipoSolucionador;

        //Nombre
        $modelo->destipsolucionador = strtoupper($request->input('nombre'));
        //--
       
        $data = Tiposolucionador::latest('idtipsolucionador')->first();
        //return response()->json($data);

        if(is_null($data)){
            $modelo->idtipsolucionador = 1;
        }else{
            $modelo->idtipsolucionador = $data['idtipsolucionador'] + 1;
        }
       
        // if (isset($data['nombre'])) {
        //     return redirect()->route('tiposolucionador.index')->with('alerta','¡Ya existe el solucionador!');
        // }
            
       $modelo->save();
       return redirect()->route('tiposolucionador.index')->with('mensaje','El tipo de solucionador '.$modelo->nombre.' creado con exito.');                             
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
        $tiposolu = Tiposolucionador::findOrFail($id);
        $nombre = $tiposolu->destipsolucionador;
        Tiposolucionador::destroy($id);
        return redirect()->route('tiposolucionador.index')->with('mensaje','Tipo Solucionador '.$nombre.' borrado con éxito!.');  
    }

    public function pdf()
    {
    }
}
