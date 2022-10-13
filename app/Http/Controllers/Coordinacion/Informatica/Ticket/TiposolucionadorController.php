<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Tic_Solucionador;
use App\Models\Iprodha\Tic_Tipsolucionador;
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
        $name = $request->query->get('name');
        
        if (!isset($name)) {
               
            //Con paginación
            $Tipos = Tic_Tipsolucionador::orderBy('idtipsolucionador', 'asc')
                                                             ->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $Tipos = Tic_Tipsolucionador::whereRaw('UPPER(destipsolucionador) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idtipsolucionador', 'asc')->paginate(10);
        }
        
        return view('Coordinacion.Informatica.ticket.tiposolucionador.index',compact('Tipos'));    
    }
    
    public function create(Request $request)
    {
        return view('Coordinacion.Informatica.ticket.tiposolucionador.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
             'nombre' => 'required|string',
        ]);

        $input = $request->all();

        $modelo = new Tic_Tipsolucionador;

        //Nombre
        $modelo->destipsolucionador = strtoupper($request->input('nombre'));
        //--
       
        $data = Tic_Tipsolucionador::latest('idtipsolucionador')->first();

        if(is_null($data)){
            $modelo->idtipsolucionador = 1;
        }else{
            $modelo->idtipsolucionador = $data['idtipsolucionador'] + 1;
        }
        $modelo->save();
        
       return redirect()->route('tiposolucionador.index')->with('mensaje','El tipo de solucionador '.$modelo->nombre.' creado con exito.');                             
    }

    public function show($id)
    {
    }
   
    public function edit(Request $request, $id)
    {
        $tipo = Tic_Tipsolucionador::findOrFail($id);
    
        return view('Coordinacion.Informatica.ticket.tiposolucionador.editar',compact('tipo'));
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
       ]);
    
        $modelo = Tic_Tipsolucionador::findOrFail($id);
        $modelo->destipsolucionador = strtoupper($request->input('nombre'));
        $modelo->save();
    
        return redirect()->route('tiposolucionador.index')->with('mensaje',$request->input('nombre').' editado exitosamente.');                                       
    }

    public function destroy($id)
    {
        $tiposolu = Tic_Tipsolucionador::findOrFail($id);
        $nombre = $tiposolu->destipsolucionador;
        Tic_Tipsolucionador::destroy($id);
        return redirect()->route('tiposolucionador.index')->with('mensaje','Tipo Solucionador '.$nombre.' borrado con éxito!.');  
    }

    public function pdf()
    {
    }
}
