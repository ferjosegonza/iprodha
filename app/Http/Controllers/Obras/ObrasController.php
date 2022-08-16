<?php

namespace App\Http\Controllers\Obras;
use App\Http\Controllers\Controller;
use App\Models\Iprodha\Obras;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
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

class ObrasController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-OBRAS|CREAR-OBRAS|EDITAR-OBRAS|BORRAR-OBRAS', ['only' => ['index']]);
        $this->middleware('permission:CREAR-OBRAS', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-OBRAS', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-OBRAS', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        //$name = $request->query->get('name');
       /* if (!isset($name)) {               */
            //Con paginación
            //$obras = Obras::all();
            //return view('obras.index', ['Obras' => $obras]);

            $Obras = Obras::orderBy('nom_obr', 'asc')->paginate(10);
            //$Obras = Obras::all();
            return view('obras.index',compact('Obras'));
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo
            //  {!! $roles->links() !!}
        /*} else {*/
            //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
            //$Obras = Obras::whereRaw('UPPER(nom_obr) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('nom_obr', 'asc')->paginate(5);
            //return view('obras.index',compact('Obras'));
        //}
    }
    
    public function create(Request $request)
    {
        return view('obras.crear');   
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
            'nom_obr' => 'required|min:5|max:250|string',
            'expedte' => 'required|min:9|max:9|string',
        ]);
        //$show = Obras::create($validatedData);
        //crea directamente sin ID
        
        $input = $request->all();
        $modelo = new Obras;
        $modelo->id_obra = $request->input('id_obr');
        $modelo->nom_obr = $request->input('nom_obr');
        $modelo->expedte = $request->input('expedte');          
        $data = Obras::latest('id_obr')->first();
        if(($data['id_obr'] )=='') {
            $modelo->id_obra=    1;
        }else{
            $modelo->id_obra= $data['id_obr'] +1;
        }
        
        $modelo->save();
        return redirect()->route('obras.index')->with('mensaje','La obra '.$modelo->nom_obr.' creada con exito.');
    }
    
    public function edit( $idobra)
    {
            $unaobra = Obras::find($idobra);
            return view('obras.editar', ['unaobra' => $unaobra]);
    }
    /*public function show(){ 
        return redirect()->route('obras.update');
     }   */
 

    public function update(Request $request,$id_obra)
    {   
        $this->validate($request, [
            //'id_obra' => 'required|min:4|max:6|string',
            'nom_obr' => 'required|min:5|max:250|string',
            'expedte' => 'required|min:9|max:9|string',
        ]);
        
        //$input = $request->all();
        //$data = Obras::where('id_obra', $input['id_obra'])->first();
        /*if (isset($data['id_obra'])) {
            if ($idconcepto != $data['id_obra']) {
                return redirect()->route('Obras.index')->with('alerta','Ya existe la obra.!');
            }
        }*/
        $unaobra = Obras::find($id_obra);
        $unaobra->nom_obr = $request->input('nom_obr');
        $unaobra->expedte = $request->input('expedte');
        $unaobra->save();
        return redirect()->route('obras.index')->with('mensaje','Obra '.$request->input('nom_obr').' editado con éxito!.');
    }

    public function destroy($id_obra)
    {        
        $unaobra = Obras::find($id_obra);
        //Obras::find($id_obra)->delete();
        $unaobra->delete();
        return redirect()->route('obras.index')->with('mensaje','Obra '. $unaobra->nom_obr.' borrado con éxito!.');  
    }
}
