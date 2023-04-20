<?php

namespace App\Http\Controllers\Planificacion\Planificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Ob_obra;
use App\Models\Iprodha\Ob_vivienda;
use App\Models\Iprodha\Ob_entrega;
use App\Models\Iprodha\Localidad;
use App\Models\Iprodha\Empresa;

class ObraviviendaController extends Controller
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
        $page = $request->query->get('page');
        $obras = [];

        if(isset($name)){
            $obras = Ob_obra::where('num_obr', 'like', '%'.$name.'%')->orWhere('nom_obr', 'like', '%' . strtoupper($name) . '%')->orderBy('num_obr','asc')->take(300)->get();
        }
        // return count($obras);
        return view('Planificacion.Planificacion.Obravivienda.index', compact('obras'));
    }
    
    public function create(Request $request)
    {
        $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc'); 
        $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp'); 
        return view('Planificacion.Planificacion.Obravivienda.crear', compact('Localidad', 'Empresa'));
    }

    public function store(Request $request)
    {
                                   
    }

    public function show($id)
    {
        $obra = Ob_obra::find($id);
        // return $obra->getEtapas;
        // $entregas = Ob_entrega::where('id_obr', $id)->get();
        return view('Planificacion.Planificacion.Obravivienda.show', compact('obra'));
    }
   
    public function edit(Request $request, $id)
    {
        
    }
    
    public function update(Request $request, $id)
    { 
                                      
    }

    public function destroy($id)
    {
          
    }

    public function verViv($id){
        $obra = Ob_obra::find($id);
        return view('Planificacion.Planificacion.Obravivienda.altaviv', compact('obra'));
    }

    public function viviendaDeObra($id, $orden){
        $obra = Ob_obra::find($id);
        $viviendas = null;
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas as $vivienda) {
                    if($vivienda->orden == $orden){
                        $viviendas = $vivienda;
                    }
                }
            }
        }     
        return $viviendas;
    }

    public function verEta($id){
        $obra = Ob_obra::find($id);
        return view('Planificacion.Planificacion.Obravivienda.altaeta', compact('obra'));
    }
}