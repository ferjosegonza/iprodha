<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Tic_Catproblema;
use App\Models\Iprodha\Tic_Catproblemasub;
use App\Models\Iprodha\Tic_Solucionador;
use \PDF;


class CategoriaproblemaController extends Controller
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
            $CatProbs = Tic_Catproblema::orderBy('idcatprob', 'asc')
                                                             ->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $CatProbs = Tic_Catproblema::whereRaw('UPPER(descatprob) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idcatprob', 'asc')->paginate(10);
        }
        
        return view ('Coordinacion.Informatica.ticket.categoriaproblema.index', compact('CatProbs'));
    }
    
    public function create(Request $request)
    {
        return view ('Coordinacion.Informatica.ticket.categoriaproblema.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'baja' => 'required|date'
       ]);

       $input = $request->all();

       $modelo = new Tic_Catproblema;

       //Nombre
       $modelo->descatprob = strtoupper($request->input('nombre'));
       $modelo->baja = $request->input('baja');
       //--
      
       $data = Tic_Catproblema::latest('idcatprob')->first();

       if(is_null($data)){
           $modelo->idcatprob = 1;
       }else{
           $modelo->idcatprob = $data['idcatprob'] + 1;
       }
           
      $modelo->save();
      return redirect()->route('categoriaprob.index')->with('mensaje','La categoria problema '.$modelo->nombre.' creado con exito.');                             
    }

    public function show($id)
    {
    }
   
    public function edit(Request $request, $id)
    {
        $categ = Tic_Catproblema::findOrFail($id);
    
        return view('Coordinacion.Informatica.ticket.categoriaproblema.editar',compact('categ'));
    }
    
    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'nombre' => 'required|string',
            'baja' => 'required|String',
       ]);
    
        $modelo = Tic_Catproblema::findOrFail($id);
        $modelo->descatprob = strtoupper($request->input('nombre'));
        $modelo->baja = $request->input('baja');
        $modelo->save();
    
        return redirect()->route('categoriaprob.index')->with('mensaje',$request->input('nombre').' editado exitosamente.');                                                                                                                           
    }

    public function destroy($id)
    {
        $categ = Tic_Catproblema::findOrFail($id);
        $nombre = $categ->destipsolucionador;
        Tic_Catproblema::destroy($id);
        return redirect()->route('categoriaprob.index')->with('mensaje','Categoria Problema '.$nombre.' borrado con éxito!.');  
    }

    public function pdf()
    {
    }

    public function byCategorias($id){
        return Tic_Catproblemasub::where('idcatprob', $id)->get();
    }

    public function bySolucionadores($id){
        $idtipo = Tic_Catproblema::where('idcatprob', '=', $id)->first();
        return Tic_Solucionador::where('idtipsolucionador', $idtipo->idtipsolucionador)->get();
    }
}
