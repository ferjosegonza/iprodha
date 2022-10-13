<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Tic_Solucionador;
use App\Models\Iprodha\Tic_Tipsolucionador;
use \PDF;


class SolucionadorController extends Controller
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
        $name = $request->query->get('name');
        
        if (!isset($name)) {
               
            //Con paginación
            $Solucionadores = Tic_Solucionador::where('idsolucionador', '>=', '1')->orderBy('idsolucionador', 'asc')->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $Solucionadores = Tic_Solucionador::whereRaw('UPPER(nombre) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idsolucionador', 'asc')->paginate(10);
        }
        return view('Coordinacion.Informatica.ticket.solucionador.index',compact('Solucionadores'));   
    }
    
    public function create(Request $request)
    {
        $Tipos = Tic_Tipsolucionador::all();
        return view('Coordinacion.Informatica.ticket.solucionador.crear', compact('Tipos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
             'nombre' => 'required|string',
             'tipo' => 'required|String',
        ]);

        $input = $request->all();

        $modelo = new Tic_Solucionador;

        //Nombre
        $modelo->nombre = strtoupper($request->input('nombre'));
        $modelo->idtipsolucionador = $request->input('tipo');
        //--
              
        $data = Tic_Solucionador::latest('idsolucionador')->first();
     
        if(!$data != null){
            $modelo->idsolucionador = 1;
        }else{
            $modelo->idsolucionador = $data['idsolucionador'] + 1;
        }

        $modelo->save();
        return redirect()->route('solucionador.index')->with('mensaje','El solucionador '.$modelo->nombre.' creado con exito.');                             
    }

    public function show($id)
    {
        
    }

   
    public function edit(Request $request, $id)
    {
        $Solucionador = Tic_Solucionador::findOrFail($id);
        $Tipos = Tic_Tipsolucionador::all();
        return view('Coordinacion.Informatica.ticket.solucionador.editar',compact('Solucionador','Tipos'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'tipo' => 'required|String',
       ]);
    
        $modelo = Tic_Solucionador::find($id);
        $modelo->nombre = strtoupper($request->input('nombre'));
        $modelo->idtipsolucionador = $request->input('tipo');
        $modelo->save();
    
        return redirect()->route('solucionador.index')->with('mensaje',$request->input('nombre').' editado exitosamente.');                                                                                      
    }

    public function destroy($id)
    {
        $solucionador = Tic_Solucionador::findOrFail($id);
        $nombre = $solucionador->nombre;
        Tic_Solucionador::destroy($id);
        return redirect()->route('solucionador.index')->with('mensaje','Solucionador '.$nombre.' borrado con éxito!.');
        
    }

    public function pdf()
    {
    
    }
}
