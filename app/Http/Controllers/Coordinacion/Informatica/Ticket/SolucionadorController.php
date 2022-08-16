<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Silverol\Solucionador;
use App\Models\Silverol\TipoSolucionador;
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
        //return response()->json([Solucionador::find(1)->getTipo]);
        //return Solucionador::find(1)->getTipo->destipsolucionador;
        //return response()->json([TipoSolucionador::find(1)->getSolucionador()]);

        // return ;
        if (!isset($name)) {
               
            //Con paginación
            $Solucionadores = Solucionador::orderBy('idsolucionador', 'asc')->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $Solucionadores = Solucionador::whereRaw('UPPER(nombre) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idsolucionador', 'asc')->paginate(10);
        }

        return view('ticket.solucionador.index',compact('Solucionadores'));    
        //return view('ticket.solucionador.index');
    }
    
    public function create(Request $request)
    {
        $Tipos = TipoSolucionador::all();
        return view('ticket.solucionador.crear', compact('Tipos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
             'nombre' => 'required|string',
             'tipo' => 'required|String',
        ]);

        $input = $request->all();

        $modelo = new Solucionador;

        //Nombre
        $modelo->nombre = strtoupper($request->input('nombre'));
        //--
       
        //idtipsolucionador
        // $tipsolu = TipoSolucionador::where('destipsolucionador', $request->input('tipo'));
        // $tipsolu = TipoSolucionador::all()
        //                             ->where('destipsolucionador', $request->input('tipo'));
        // $tipsolu = TipoSolucionador::where('destipsolucionador', '=', $request->input('tipo'));
        $tipsolu = TipoSolucionador::where('destipsolucionador','=',$request->input('tipo'))->select('idtipsolucionador')->get();
        return response()->json($tipsolu);
        // $modelo->idtipsolucionador = $tipsolu[0]->idtipsolucionador;
        // //--
        

        // //idsolucionador
              
        // $data = Solucionador::latest('idsolucionador')->first();
     
        // if(!$data != null){
        //     $modelo->idsolucionador = 1;
        // }else{
        //     $modelo->idsolucionador = $data['idsolucionador'] + 1;
        // }

        // $modelo->save();
        // return redirect()->route('solucionador.index')->with('mensaje','El solucionador '.$modelo->nombre.' creado con exito.');                             
    }

    public function show($id)
    {
        
    }

   
    public function edit(Request $request, $id)
    {
        $Solucionador = Solucionador::findOrFail($id);
        $Tipos = TipoSolucionador::all();
        return view('ticket.solucionador.editar',compact('Solucionador','Tipos'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'tipo' => 'required|String',
       ]);
    
        $modelo = Solucionador::find($id);
        $modelo->nombre = strtoupper($request->input('nombre'));
        $modelo->idtipsolucionador = $request->input('tipo');
        // $tipsolu = TipoSolucionador::where('idtipsolucionador','=',$request->input('tipo'))->select('idtipsolucionador')->get();
        // $modelo->idtipsolucionador = $tipsolu[0]->idtipsolucionador;
        $modelo->save();
    
        return redirect()->route('solucionador.index')->with('mensaje',$request->input('nombre').' editado exitosamente.');                                                                                      
    }

    public function destroy($id)
    {
        $solucionador = Solucionador::findOrFail($id);
        $nombre = $solucionador->nombre;
        Solucionador::destroy($id);
        return redirect()->route('solucionador.index')->with('mensaje','Solucionador '.$nombre.' borrado con éxito!.');
        
    }

    public function pdf()
    {
    
    }
}
