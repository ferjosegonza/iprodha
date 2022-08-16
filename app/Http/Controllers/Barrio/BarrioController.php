<?php

namespace App\Http\Controllers\Barrio;
use App\Http\Controllers\Controller;
use App\Models\Iprodha\Barrio;
use App\Models\Iprodha\Obras;
use App\Models\Iprodha\Localidad;
use App\Models\Iprodha\Barrio_vw_tipoxtipologia;
use App\Models\Iprodha\Barrio_programa;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\View;

//use Spatie\Permission\Models\Permission;
//use App\Http\Controllers\Controller;
/*
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;*/

class BarrioController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-BARRIO|CREAR-BARRIO|EDITAR-BARRIO|BORRAR-BARRIO', ['only' => ['index']]);
        $this->middleware('permission:CREAR-BARRIO', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-BARRIO', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-BARRIO', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {

        $name = strtoupper($request->query->get('name'));

        if (!isset($name)) {
            $Barrios = Barrio::orderBy('barrio', 'desc')->paginate(10);           
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            $Barrios = Barrio::whereRaw('UPPER(nombarrio) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('barrio', 'desc')->paginate(10);
        }            
        return view('barrio.index',compact('Barrios'));
            //Con paginación
            //$obras = Obras::all();
            //return view('obras.index', ['Obras' => $obras]);
            //return view('barrio.index',compact('Barrios'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo
            //  {!! $roles->links() !!}
    }
    
    public function create(Request $request)
    {
        return view('barrio.crear');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function store(Request $request)
    {
        //return redirect()->route('obras.index')->with('mensaje','Usuario creado con éxito!.');
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            'nombarrio' => 'required|min:10|max:250|string',
            'fecha_alta' => 'required|min:9|max:9|string',
        ]);
        //$show = Obras::create($validatedData);
        //crea directamente sin ID
        $input = $request->all();
        $modelo = new Barrio;
        $modelo->barrio = $request->input('barrio');
        $modelo->nombarrio = $request->input('nombarrio');
        $modelo->fecha_alta = $request->input('fecha_alta');          
        $data = Barrio::latest('barrio')->first();
        if(($data['barrio'] )=='') {
            $modelo->barrio=    1;
        }else{
            $modelo->barrio= $data['barrio'] +1;
        }
        
        $modelo->save();
        return redirect()->route('barrio.index')->with('mensaje','El barrio '.$modelo->nom_obr.' creado con exito.');
    }
    
    public function edit( $barrio)
    {
            $unbarrio = Barrio::find($barrio);
            
            $Localidad= Localidad::pluck('nom_loc','id_loc'); 
            $Obra= Obras::pluck('nom_obr','id_obr'); 
            $Tipo= Barrio_vw_tipoxtipologia::pluck('tipologia','idtipologia'); 
            $Tipologia= Barrio_vw_tipoxtipologia::pluck('tipobarrio','idtipbarrio'); 
            $Programa= Barrio_programa::pluck('descripcion','id_programa');             
            return view('barrio.editar',compact('unbarrio','Localidad','Obra','Tipo','Tipologia','Programa'));
    }
    /*public function show(){ 
        return redirect()->route('obras.update');
     }   */
 

    public function update(Request $request,$barrio)
    {   
        $this->validate($request, [
            //'id_obra' => 'required|min:4|max:6|string',
            'nombarrio' => 'required|min:5|max:250|string',
            'fecha_alta' => 'required|min:9|max:9|string',
        ]);
        
        //$input = $request->all();
        //$data = Obras::where('id_obra', $input['id_obra'])->first();
        /*if (isset($data['id_obra'])) {
            if ($idconcepto != $data['id_obra']) {
                return redirect()->route('Obras.index')->with('alerta','Ya existe la obra.!');
            }
        }*/
        $unbarrio = Barrio::find($barrio);
        $unbarrio->nombarrio = $request->input('nombarrio');
        $unbarrio->fec_creacion = $request->input('fecha_alta');
        $unbarrio->save();
        return redirect()->route('barrrio.index')->with('mensaje','Barrio '.$request->input('nombarrio').' editado con éxito!.');
    }

    public function destroy($barrio)
    {        
        $unbarrio = Barrios::find($barrio);
        //Obras::find($id_obra)->delete();
        $unbarrio->delete();
        return redirect()->route('barrio.index')->with('mensaje','Barrio '. $unbarrio->nombarrio.' borrado con éxito!.');  
    }
}
