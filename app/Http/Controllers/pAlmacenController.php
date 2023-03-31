<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sol\p_Almacen;
use App\Models\Sol\sector;
use Illuminate\Support\Facades\Auth;

class pAlmacenController extends Controller{

    
    function __construct(){
        $this->middleware('auth');
        //esto de aca abajo me parece que no anda xD
        $this->middleware('permission:VER-ALMACENES|CREAR-ALMACENES|EDITAR-ALMACENES|BORRAR-ALMACENES', ['only' => ['index']]);
        $this->middleware('permission:CREAR-ALMACENES', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-ALMACENES', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-ALMACENES', ['only' => ['destroy']]);
    }  

    public function index(Request $request) 
    {
        $pAlmacenes = p_Almacen::orderBy('id_almacen', 'asc')->get();
        $sectores=sector::orderBy('id_sector','asc')->get();
        return view('almacen.index')   
        ->with("almacen", $pAlmacenes)
        ->with("sectores", $sectores);
    }

    public function create(Request $request)
    {
        return view('almacen.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom_almacen' => 'required|string',
            'abr_almacen' => 'required|string',
            'dom_almacen' => 'required|string'
       ]);

       //NO ANDA, LOS STRING NO SON IGUALES?
       $existeAlmacenNombre = p_Almacen::where('nom_almacen','=', strtolower($request->input('nom_almacen')))->first();
       //Este si anda
       $existeAlmacenAbr = p_Almacen::where('abr_almacen','=', strtoupper($request->input('abr_almacen')))->first();
       //Este tampoco
       $existeAlmacenDom = p_Almacen::where('dom_almacen','=', strtoupper($request->input('dom_almacen')))->first();

       //la solucion más sencilla sería que la BD no sea sensible a mayusculas/minusculas 

       if(empty($existeAlmacenNombre) and empty($existeAlmacenAbr) and empty($existeAlmacenDom)){
        $palmacen = p_Almacen::create(['nom_almacen'=>$request->input('nom_almacen'), 
        'abr_almacen'=>$request->input('abr_almacen'), 'dom_almacen'=>$request->input('dom_almacen')]);
        $pAlmacenes = p_Almacen::orderBy('id_almacen', 'asc')->get();
        return redirect()->route('almacen.index')->with('mensaje','El almacen '.$palmacen->nom_almacen.' creado con exito.');
       }else{
            $pAlmacenes = p_Almacen::orderBy('id_almacen', 'asc')->get();
            if(! empty($existeAlmacenNombre)){
                return redirect()->route('almacen.index')->with('mensaje','El nombre del almacen '.$request->nom_almacen.' ya existe.');
            }
            if(! empty($existeAlmacenAbr)){
                return redirect()->route('almacen.index')->with('mensaje','La abreviatura '.$request->abr_almacen.' ya existe.');
            }
            if(! empty($existeAlmacenDom)){
                return redirect()->route('almacen.index')->with('mensaje','El domicilio '.$request->dom_almacen.' ya tiene un almacén.');
            }
       }
    }

    public function destroy($id_almacen){
        $almacen=p_Almacen::find($id_almacen)->delete();
        print($id_almacen);
        return redirect()->route('almacen.index')->with('mensaje','El almacén se borro con exito.');
    }

    public function edit(Request $request, p_Almacen $p_almacen)
    {
        return view('almacen.editar')   
        ->with("almacen", $p_almacen);
    }

    public function asignar(Request $request, p_Almacen $p_almacen)
    {
        $sectores = sector::pluck('nom_sector', 'id_sector')->toArray();
        return view('almacen.asignar')   
        ->with("almacen", $p_almacen)
        ->with("sectores", $sectores);
    }

    public function update(Request $request, $id_almacen){
        $this->validate($request, [
            'nom_almacen' => 'required|string',
            'abr_almacen' => 'required|string',
            'dom_almacen' => 'required|string'
        ]);

      
        $almacen = p_Almacen::find($id_almacen); 
        $almacen->nom_almacen = $request->nom_almacen;
        $almacen->abr_almacen = $request->abr_almacen;
        $almacen->dom_almacen = $request->dom_almacen;
        $almacen->save();
        return redirect()->route('almacen.index')->with('mensaje','El almacen se modifico con exito.');
        
    }

    public function asignarSector(Request $request, $id_almacen){
        $this->validate($request, [
            'nom_sector' => 'required|string'            
        ]);
        $almacen = p_Almacen::find($id_almacen);    
        $almacen->fk_sector = $request->nom_sector;       
        $almacen->save();
        return redirect()->route('almacen.index')->with('mensaje','El almacen se modifico con exito.');
    }
        
    public function imagen(Request $request, p_Almacen $p_almacen){
        return view('almacen.imagen', compact('p_almacen'));
    }

    public function guardarImagen(Request $request, $id_almacen){
       // return $request;
       $p_almacen = p_Almacen::find($id_almacen);   
       if(!$request->image == null){
        $this->validate($request,[
            'image' => 'file|image|mimes:jpg,png,jpeg"]'
           ]);

        $cadenaConvert = str_replace(" ", "_", Auth::user()->name);
        $filename = time().'-'. $cadenaConvert . '.' . $request->file('image')->extension();
        $path = $request->file('image')->storeAs('images/almacen', $filename, 'public_uploads');
        $p_almacen->imagen = 'storage/upload/'.$path;       
        $p_almacen->save();
        
       }
       return view('almacen.imagen', compact('p_almacen'));
       
        

    }
}



