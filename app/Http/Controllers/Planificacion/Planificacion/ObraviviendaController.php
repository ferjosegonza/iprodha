<?php

namespace App\Http\Controllers\Planificacion\Planificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//agregamos

use App\Models\Iprodha\Ob_obra;
use App\Models\Iprodha\Ob_vivienda;
use App\Models\Iprodha\Ob_entrega;
use App\Models\Iprodha\Ob_etapa;
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
        // return $request;
        // return Ob_obra::orderBy('id_obr', 'desc')->first()->id_obr + 1;
        // return Localidad::where('id_loc', $request->input('idloc'))->first()->id_mun;
        //Validar los datos
        $this->validate($request, [
            'num_obr' => 'required|string',
            'nom_obra' => 'required|string',
            'idempresa' => 'required|min:1',
            'idloc' => 'required|min:1',
            'can_viv' => 'required',
            'descrip' => 'required|string',

        ]);

        // $idparalaobra = Ob_obra::orderBy('id_obr', 'desc')->first()->id_obr + 1;
        //Crear la obra
        $obra = Ob_obra::create([
            'num_obr' => $request->input('num_obr'),
            'nom_obr' => strtoupper($request->input('nom_obra')),
            'id_emp' => $request->input('idempresa'),
            'id_loc' => $request->input('idloc'),
            'can_viv' => $request->input('can_viv')
        ]);

        if($request->input('plazo')){
            $obra->update([
                'plazo' => $request->input('plazo')
            ]);
        }

        if($request->input('expediente')){
            $obra->update([
                'expedte' => $request->input('expediente')
            ]);
        }

        if($request->input('fec_ini')){
            $obra->update([
                'fec_ini' => $request->input('fec_ini')
            ]);
        }

        if($request->input('plazo')){
            $obra->update([
                'fec_ter' => $request->input('fec_ter')
            ]);
        }

        //Obtener el id de la obra que se genero en la BD
        $id_obr = Ob_obra::where('num_obr', $obra->num_obr)->first()->id_obr;

        //Crear la etapa
        $etapa = Ob_etapa::create([
            'id_obr' => $id_obr,
            'nro_eta' => 1,
            'descripcion' => strtoupper($request->input('descrip')),
            'can_viv_2' => $request->input('can_viv_2'),
            'can_viv_3' => $request->input('can_viv_3'),
            'can_viv_4' => $request->input('can_viv_4'),
            'id_localidad' => $request->input('idloc')
        ]);

        //Obtener la id de la etapa que se genero en la BD
        $id_etapa = Ob_etapa::where('id_obr', $id_obr)->first()->id_etapa;

        //Crear entrega
        $entrega = Ob_entrega::create([
            'id_eta' => $id_etapa,
            'num_ent' => 0,
            'cant_viv' => $request->input('can_viv'),
            'fec_ent' => null
        ]);

        //Obtener la id de la entrega que se genero en la BD
        $id_ent = Ob_entrega::where('id_eta', $id_etapa)->first()->id_ent;

        //Crear las viviendas
        for ($i=1; $i <= $request->input('can_viv'); $i++) { 
            Ob_vivienda::create([
                'orden' => $i,
                'id_mun' => Localidad::where('id_loc', $request->input('idloc'))->first()->id_mun,
                'id_ent' => $id_ent
            ]);
        }

        return redirect()->route('obravivienda.index')->with('mensaje','La obra se creo con exito.');  
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
        $obra = Ob_obra::find($id);
        $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc'); 
        $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp'); 
        return view('Planificacion.Planificacion.Obravivienda.editar', compact('obra', 'Localidad', 'Empresa'));
    }
    
    public function update(Request $request, $id)
    { 
        // return $request;
        // if($request->input('plazo')){
        //     return "chau";
        // }else {
        //     return $request;
        // }
        
        $this->validate($request, [
            'id_obr' => 'required',
            'num_obr' => 'required|string',
            'nom_obra' => 'required|string',
            'idempresa' => 'required',
            'idloc' => 'required',
            'can_viv' => 'required',
        ]);

        $obra = Ob_obra::find($id);

        // return $obra;
        $obra->update([
            'num_obr' => $request->input('num_obr'),
            'nom_obr' => strtoupper($request->input('nom_obra')),
            'id_emp' => $request->input('idempresa'),
            'id_loc' => $request->input('idloc'),
            'can_viv' => $request->input('can_viv')
        ]);
        
        if($request->input('plazo')){
            $obra->update([
                'plazo' => $request->input('plazo')
            ]);
        }

        if($request->input('expediente')){
            $obra->update([
                'expedte' => $request->input('expediente')
            ]);
        }

        if($request->input('fec_ini')){
            $obra->update([
                'fec_ini' => $request->input('fec_ini')
            ]);
        }

        if($request->input('fec_ter')){
            $obra->update([
                'fec_ter' => $request->input('fec_ter')
            ]);
        }
        return redirect()->route('obravivienda.index')->with('mensaje','La obra se modifico con exito.');                                
    }

    public function destroy($id)
    {
          
    }

    public function verViv($id){
        $obra = Ob_obra::find($id);
        $viviendas = array();;
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas as $vivienda) {
                    array_push($viviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden]);
                }
            }
        } 
        return view('Planificacion.Planificacion.Obravivienda.altaviv', compact('obra', 'viviendas'));
    }

    public function viviendaDeObra($id){
        return Ob_vivienda::find($id);
    }

    public function viviendaDeObraId($id){
        
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

    public function guardarVivienda(Request $request){
        $this->validate($request, [
            'vivienda' => 'required',
        ]);
        // return $request;
        $id_viv = $request->input('vivienda');
        $id_obr = $request->input('id_obr');

        $vivienda = Ob_vivienda::find($id_viv);
        //{"_token":"1soB2pFkgdUStxJ507a2aciyoFjxIazZNhl7WpHB","id_obr":"11581","plano":"123546","partida":"1254","partidaucac":null,"vivdisc":"0","vivienda":"137563","seccion":null,"chacra":null,"manzana":null,"parcela":null,"finca":null,"edif":"0","piso":"0","depto":"0","esca":"0","unfun":"0","letmanza":null,"lote":null,"numcalle":null,"nomcalle":null,"ent_calles":null,"num_finca":"0","sup_lote":null,"deslinde":null}
        if($request->input('plano')){
            $vivienda->update([
                'plano' => $request->input('plano')
            ]);
        }

        if($request->input('partida')){
            $vivienda->update([
                'partida' => $request->input('partida')
            ]);
        }

        if($request->input('partidaucac')){
            $vivienda->update([
                'partida_2' => $request->input('partidaucac')
            ]);
        }

        if(!is_null($request->input('vivdisc'))){
            $vivienda->update([
                'discap' => $request->input('vivdisc')
            ]);
        }

        if($request->input('seccion')){
            $vivienda->update([
                'seccion' => $request->input('seccion')
            ]);
        }

        if($request->input('chacra')){
            $vivienda->update([
                'chacra' => $request->input('chacra')
            ]);
        }

        if($request->input('manzana')){
            $vivienda->update([
                'manzana' => $request->input('manzana')
            ]);
        }

        if($request->input('parcela')){
            $vivienda->update([
                'parcela' => $request->input('parcela')
            ]);
        }

        if($request->input('finca')){
            $vivienda->update([
                'finca' => $request->input('finca')
            ]);
        }
        
        if($request->input('edif') != 0){
            $vivienda->update([
                'edificio' => $request->input('edif')
            ]);
        }

        if($request->input('piso') != 0){
            $vivienda->update([
                'piso' => $request->input('piso')
            ]);
        }

        if($request->input('depto') != 0){
            $vivienda->update([
                'departamento' => $request->input('depto')
            ]);
        }

        if($request->input('esca') != 0){
            $vivienda->update([
                'escalera' => $request->input('esca')
            ]);
        }

        if($request->input('unfun') != 0){
            $vivienda->update([
                'uni_fun' => $request->input('unfun')
            ]);
        }

        if($request->input('letmanza')){
            $vivienda->update([
                'man_emp' => $request->input('letmanza')
            ]);
        }

        if($request->input('lote')){
            $vivienda->update([
                'lot_emp' => $request->input('lote')
            ]);
        }

        if($request->input('numcalle')){
            $vivienda->update([
                'num_cal' => $request->input('numcalle')
            ]);
        }

        if($request->input('nomcalle')){
            $vivienda->update([
                'nom_cal' => $request->input('nomcalle')
            ]);
        }

        if($request->input('ent_calles')){
            $vivienda->update([
                'entrecalles' => $request->input('ent_calles')
            ]);
        }

        if($request->input('num_finca')){
            $vivienda->update([
                'sup_fin' => $request->input('num_finca')
            ]);
        }

        if($request->input('sup_lote')){
            $vivienda->update([
                'sup_lot' => $request->input('sup_lote')
            ]);
        }

        if($request->input('deslinde')){
            $vivienda->update([
                'deslinde' => $request->input('deslinde')
            ]);
        }

        return redirect()->route('obravivienda.viviendas', $id_obr)->with('mensaje','La vivienda se modifico con exito.');
    }

    public function verEta($id){
        $obra = Ob_obra::find($id);
        return view('Planificacion.Planificacion.Obravivienda.altaeta', compact('obra'));
    }

    public function asignarVivEnt($id, $entrega){
        $obra = Ob_obra::find($id);
        $listaViviendas = array();
        $viviendaDeEntrega = Ob_vivienda::where('id_ent', $entrega)->get();
        $todasLasViviendas = array();

        $entre = Ob_entrega::find($entrega);
        $etapa = Ob_etapa::find($entre->id_eta);
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas as $vivienda) {
                    array_push($todasLasViviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden]);
                }
            }
        }

        foreach ($viviendaDeEntrega as $vivienda) { 
            array_push($listaViviendas, $vivienda->id_viv);
         }
        // return $etapa;
        return view('Planificacion.Planificacion.Obravivienda.asignarviv', compact('obra', 'entrega', 'listaViviendas', 'todasLasViviendas', 'entre', 'etapa'));
    }

    public function cargaMasiva($id){
        $obra = Ob_obra::find($id); 
        return view('Planificacion.Planificacion.Obravivienda.cargamasiva', compact('obra'));
    }

    public function guardarCargaMasiva(Request $request, $id){
        return $request;
        $this->validate($request, [
            'ordenDesde' => 'required',
            'ordenHasta' => 'required',
        ]);

        $desde = $request->input('ordenDesde');
        $hasta = $request->input('ordenHasta');
        $obra = Ob_obra::find($id);

        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas as $vivienda) {
                    if($vivienda->orden >= $desde && $vivienda->orden <= $hasta){
                        echo($vivienda->orden);
                        echo('hola');

                        if($request->input('plano')){
                            $vivienda->update([
                                'plano' => $request->input('plano')
                            ]);
                        }

                        if($request->input('seccion')){
                            $vivienda->update([
                                'seccion' => $request->input('seccion')
                            ]);
                        }

                        if($request->input('chacra')){
                            $vivienda->update([
                                'chacra' => $request->input('chacra')
                            ]);
                        }

                        if($request->input('manzana')){
                            $vivienda->update([
                                'manzana' => $request->input('manzana')
                            ]);
                        }

                        if($request->input('letmanza')){
                            $vivienda->update([
                                'man_emp' => $request->input('letmanza')
                            ]);
                        }

                        if($request->input('nomcalle')){
                            $vivienda->update([
                                'nom_cal' => $request->input('nomcalle')
                            ]);
                        }

                        if($request->input('ent_calles')){
                            $vivienda->update([
                                'entrecalles' => $request->input('ent_calles')
                            ]);
                        }

                    }
                }
            }
        }

        
    }
}