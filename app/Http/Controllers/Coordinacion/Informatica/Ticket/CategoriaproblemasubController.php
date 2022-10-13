<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Tic_Catproblema;
use App\Models\Iprodha\Tic_Catproblemasub;
use \PDF;


class CategoriaproblemasubController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-CATEGORIALABORAL|CREAR-CATEGORIALABORAL|EDITAR-CATEGORIALABORAL|BORRAR-CATEGORIALABORAL', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {    
        $name = $request->query->get('name');
        
        if (!isset($name)) {
               
            //Con paginación
            $CatProbsubs = Tic_Catproblemasub::orderBy('idcatprobsub', 'asc')->simplePaginate(10);
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $CatProbsubs = Tic_Catproblemasub::whereRaw('UPPER(catprobsub) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('idcatprobsub', 'asc')->paginate(10);
        }
        
        return view ('Coordinacion.Informatica.ticket.categoriaproblemasub.index', compact('CatProbsubs'));
    }
    
    public function create(Request $request)
    {
        $Categorias = Tic_Catproblema::orderBy('descatprob','asc')->get();
        return view ('Coordinacion.Informatica.ticket.categoriaproblemasub.crear', compact('Categorias'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'categ' => 'required|string',
            'nombre' => 'required|string'
        ]);

        $input = $request->all();

        $modelo = new Tic_Catproblemasub;

        //Nombre
        $modelo->catprobsub = strtoupper($request->input('nombre'));
        $modelo->idcatprob = $request->input('categ');
        //--

        $data = Tic_Catproblemasub::latest('idcatprobsub')->first();

        if(is_null($data)){
            $modelo->idcatprobsub = 1;
        }else{
            $modelo->idcatprobsub = $data['idcatprobsub'] + 1;
        }

        $modelo->save();
        return redirect()->route('categoriaprobsub.index')->with('mensaje','La sub-categoria problema '.$modelo->catprobsub.' creado con exito.');                             
    }

    public function show($id)
    {
    }
   
    public function edit(Request $request, $id)
    {
        $categsub = Tic_Catproblemasub::findOrFail($id);
        $Categorias = Tic_Catproblema::all();
        return view('Coordinacion.Informatica.ticket.categoriaproblemasub.editar',compact('categsub','Categorias'));
    }
    
    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'nombre' => 'required|string',
            'categ' => 'required|String',
       ]);
    
        $modelo = Tic_Catproblemasub::findOrFail($id);
        $modelo->catprobsub = strtoupper($request->input('nombre'));
        $modelo->idcatprob = $request->input('categ');
        $modelo->save();
    
        return redirect()->route('categoriaprobsub.index')->with('mensaje',$request->input('nombre').' editado exitosamente.');                                                                                           
    }

    public function destroy($id)
    {
        $categsub = Tic_Catproblemasub::findOrFail($id);
        $nombre = $categsub->catprobsub;
        Tic_Catproblemasub::destroy($id);
        return redirect()->route('categoriaprobsub.index')->with('mensaje','Sub Categoria Problema '.$nombre.' borrado con éxito!.');  
    }

    public function pdf()
    {
    }

    public function byCategorias($id){
        return Tic_Catproblemasub::where('idcatprob', $id)->get();
    }

}