<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sol\sector;

class sectorController extends Controller{

    function __construct(){
        $this->middleware('auth');
        //esto de aca abajo me parece que no anda xD
        $this->middleware('permission:VER-SECTOR|CREAR-SECTOR|EDITAR-SECTOR|BORRAR-SECTOR', ['only' => ['index']]);
        $this->middleware('permission:CREAR-SECTOR', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-SECTOR', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-SECTOR', ['only' => ['destroy']]);
    }

    public function index(Request $request) 
    {
        $sectores = sector::orderBy('id_sector', 'asc')->get();
        return view('sector.index', compact('sectores'));
    }

    public function create(Request $request)
    {
        return view('sector.crear');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom_sector' => 'required|string',
            'desc_sector' => 'string|nullable'
       ]);

       $sectores = sector::orderBy('id_sector', 'asc')->get();
       if (empty($sectores)){
        $sector = sector::create(['id_sector'=>1,'nom_sector'=>$request->input('nom_sector'), 
        'desc_sector'=>$request->input('desc_sector')]);
        return redirect()->route('sector.index')->with('mensaje','El sector '.$sector->nom_sector.' creado con exito.');
       }
       else{
        $id=last($sectores) + 1;
            $existeSectorNombre = sector::where('nom_sector','=', strtolower($request->input('nom_sector')))->first();
        
            //la solucion más sencilla sería que la BD no sea sensible a mayusculas/minusculas 

            if(empty($existeSectorNombre)){
                $sector = sector::create(['id_sector'=>$id,'nom_sector'=>$request->input('nom_sector'), 
                'desc_sector'=>$request->input('desc_sector')]);
                return redirect()->route('sector.index')->with('mensaje','El sector '.$sector->nom_sector.' creado con exito.');
            }else{
                return redirect()->route('sector.index')->with('mensaje','El nombre del sector '.$request->nom_sector.' ya existe.');
                    
            }
       }       
    }

    public function destroy($id_sector){
        $sector=sector::find($id_sector)->delete();
        print($id_sector);
        return redirect()->route('sector.index')->with('mensaje','El sector se borro con exito.');
    }

    public function edit(Request $request, sector $sector)
    {
        return view('sector.editar')   
        ->with("sector", $sector);
    }

    public function update(Request $request, $id_sector){
        $this->validate($request, [
            'nom_sector' => 'required|string',
            'desc_sector' => 'string|nullable'
       ]);
    
       $existeSectorNombre = sector::where('nom_sector','=', strtolower($request->input('nom_sector')))->first();
      
       //la solucion más sencilla sería que la BD no sea sensible a mayusculas/minusculas 

       if(empty($existeSectorNombre)){
        $sector = sector::find($id_sector); 
        $sector->nom_sector = $request->nom_sector;
        $sector->desc_sector = $request->desc_sector;
        $sector->save();
        return redirect()->route('sector.index')->with('mensaje','El sector se modifico con exito.');}
       else{
           return redirect()->route('sector.index')->with('mensaje','El nombre del sector '.$request->nom_sector.' ya existe.');
        }    

    }

}