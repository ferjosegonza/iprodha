<?php

namespace App\Http\Controllers\Planificacion\Planificacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
//agregamos
// use App\Models\User;

use App\Models\Iprodha\Ob_obra;
use App\Models\Iprodha\Ob_vivienda;
use App\Models\Iprodha\Ob_entrega;
use App\Models\Iprodha\Ob_etapa;
use App\Models\Iprodha\Localidad;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\ob_operatoria;
use App\Models\Iprodha\Membrete;
use App\Models\Iprodha\Ob_tip_obr;
use App\Models\Iprodha\Municipios;
//Gestion de usuario oracle
use App\Traits\ConectarUserDB;


class ObraviviendaController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-OBRAVIVIENDA|CREAR-OBRAVIVIENDA|EDITAR-OBRAVIVIENDA|BORRAR-OBRAVIVIENDA', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);
    }
    
    // public function conectar(){
    //     Config::set('database.connections.oracleuser.username', Lav_user_db::find(Auth::user()->id)->user_lav);
    //     Config::set('database.connections.oracleuser.password', Crypt::decryptString(Lav_user_db::find(Auth::user()->id)->pass_lav));
    // }
    use ConectarUserDB;

    public function index(Request $request)
    {
        $this->conectar();
        $name = $request->query->get('name');
        $page = $request->query->get('page');
        $opcion = $request->input('opcionbusq');
        $obras = [];
        // return $request;
        if(isset($name)){

            switch ($opcion) {
                case 0:
                    $obras = Ob_obra::where('num_obr', 'like', '%'.$name.'%')
                            ->orWhere('nom_obr', 'like', '%' . strtoupper($name) . '%')
                            ->orWhere('expedte', 'like', '%' . strtoupper($name) . '%')
                            ->orderBy('num_obr','asc')->take(100)
                            ->get();
                    break;

                case 1:
                    $obras = Ob_obra::where('num_obr', $name)
                                    ->take(100)
                                    ->get();
                    break;
                
                case 2:
                    $obras = Ob_obra::where('nom_obr', 'like', '%' . strtoupper($name) . '%')
                                    ->orderBy('num_obr', 'desc')
                                    ->take(100)
                                    ->get();
                    break;

                case 3:
                    $obras = Ob_obra::where('expedte', 'like', '%' . strtoupper($name) . '%')
                                    ->take(100)
                                    ->get();
                    break;

                case 4:
                    // $vivienda = Ob_vivienda::where('plano', $name)->first();
                    // if(!is_null($vivienda)){
                    //     $idobr = $vivienda->getEntrega->getEtapa->id_obr;
                    //     $obras = Ob_obra::where('id_obr', $idobr)->get();
                    // }

                    $viviendas = Ob_vivienda::where('plano', $name)->get();

                    foreach ($viviendas as $vivienda) {
                        try {
                            $vivs[] = $vivienda->getEntrega->getEtapa->id_obr;
                        } catch (\Throwable $th) {
                            $vivs[] = null;
                        }
                        
                    }

                    if(count($viviendas) != 0){
                        $vivs = array_unique($vivs);
                        $obras = Ob_obra::whereIn('id_obr', $vivs)->orderBy('num_obr', 'desc')->take(100)->get();
                    }

                    break;

                case 5:
                    $empresas = Empresa::where('nom_emp', 'like', '%' . strtoupper($name) . '%')->get();
                    foreach ($empresas as $empresa) {
                        $empid[] = $empresa->id_emp;
                    }

                    if (count($empresas) != 0) {
                        $obras = Ob_obra::whereIn('id_emp', $empid)
                                        ->orderBy('num_obr', 'desc')
                                        ->take(100)
                                        ->get();
                    }
                    break;

                case 6:
                    $localidades = Localidad::where('nom_loc', 'like', '%' . strtoupper($name) . '%')->get();
                    foreach ($localidades as $localidad) {
                        $locid[] = $localidad->id_loc;
                    }
                    
                    if (count($localidades) != 0) {
                        $obras = Ob_obra::whereIn('id_loc', $locid)
                                                ->orderBy('num_obr', 'asc')
                                                ->take(100)
                                                ->get();
                    }
                    break;

                default:
                    $obras = Ob_obra::orderBy('id_obr', 'desc')->limit(5)->get();
                    break;
            }
             
        }else{
            $obras = Ob_obra::orderBy('id_obr', 'desc')->limit(5)->get();
        }

        return view('Planificacion.Planificacion.Obravivienda.index', compact('obras', 'opcion'));
    }
    
    public function indexConvenios(Request $request)
    {
        $this->conectar();
        
        $obras = [];
        $obras = Ob_obra::whereBetween('num_obr', ['20000', '30000'])->orderBy('num_obr', 'desc')->get();
        $opcion = 1;
        return view('Planificacion.Planificacion.Obravivienda.index', compact('obras', 'opcion'));
    }

    public function create(Request $request)
    {
        // $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc'); 
        // $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        //$TipoOpe = ob_operatoria::whereNotNull('operat_adm')->orderBy('operat_adm', 'asc')->pluck('operat_adm', 'id_ope');
        $TipoObra = Ob_tip_obr::orderBy('tipo_obra')->pluck('tipo_obra','id_tip_obr');
        $TipoOpe = ob_operatoria::where('certifica', 1)->orderBy('operatoria', 'asc')->pluck('operatoria', 'id_ope');
        $Localidad = Localidad::orderBy('nom_loc')->get();
        $Empresa = Empresa::orderBy('nom_emp')->get();
        return view('Planificacion.Planificacion.Obravivienda.crear', compact('Localidad', 'Empresa', 'TipoOpe', 'TipoObra'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'num_obr' => 'required|string',
            'nom_obra' => 'required|string',
            'num_eta' => 'required',
            'idempresa' => 'required',
            'idloc' => 'required',
            'can_viv' => 'required',
            'descrip' => 'required|string|max:80',

        ], [
            'num_obr.required' => 'El campo Numero de obra es obligatorio.',
            'nom_obra.required' => 'El campo Obra es obligatorio.',
            // 'idempresa.min' => 'Seleccione una empresa valida.',
            // 'idloc.min' => 'Seleccione una provincia valida.',
            'can_viv.required' => 'El campo Cantidad de viviendas de obra es obligatorio.',
            'descrip.required' => 'El campo Descripcion de una etapa es obligatorio.',
            'descrip.max' => 'El campo Descripcion de la estapa es muy largo'
        ]);

       /* DB::transaction(function() use ($request){
            $this->conectar();
            $obra = Ob_obra::create([
                'num_obr' => $request->input('num_obr'),
                'nom_obr' => strtoupper($request->input('nom_obra')),
                'id_emp' => $request->input('idempresa'),
                'id_loc' => $request->input('idloc'),
                'can_viv' => $request->input('can_viv')
            ]);

            if($request->input('idtipobr')){
                $obra->update([
                    'id_tip_obr' => $request->input('idtipobr')
                ]);
            }

            if($request->input('plazo')){
                $obra->update([
                    'plazo' => $request->input('plazo')
                ]);
            }

            if($request->input('idope')){
                $obra->update([
                    'id_ope' => $request->input('idope')
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
            $id_obr = $obra->id_obr;

            //Crear la etapa
            $etapa = Ob_etapa::create([
                'id_obr' => $id_obr,
                'nro_eta' => 1,
                'descripcion' => strtoupper($request->input('descrip')),
                'can_viv_0' => 0,
                'can_viv_2' => 0,
                'can_viv_3' => 0,
                'can_viv_4' => 0,
                'cant_viv' => $request->input('can_viv'),
                'id_localidad' => $request->input('idloc')
            ]);

            //Obtener la id de la etapa que se genero en la BD
            $id_etapa = $etapa->id_etapa;

            //Crear entrega
            $entrega = Ob_entrega::create([
                'id_eta' => $id_etapa,
                'num_ent' => 0,
                'cant_viv' => $request->input('can_viv'),
                'fec_ent' => null
            ]);

            //Obtener la id de la entrega que se genero en la BD
            $id_ent = $entrega->id_ent;

            //Crear las viviendas
            for ($i=1; $i <= $request->input('can_viv'); $i++) { 
                Ob_vivienda::create([
                    'orden' => $i,
                    'id_mun' => Localidad::where('id_loc', $request->input('idloc'))->first()->id_mun,
                    'id_ent' => $id_ent,
                    'id_loc' => $request->input('idloc')
                ]);
            }
        });
*/
        //DB::beginTransaction();
        try {
            $this->conectar();
            
            $obra = Ob_obra::create([
                'num_obr' => $request->input('num_obr'),
                'nom_obr' => strtoupper($request->input('nom_obra')),
                'id_emp' => $request->input('idempresa'),
                'id_loc' => $request->input('idloc'),
                'can_viv' => $request->input('can_viv')
            ]);

            if($request->input('idtipobr')){
                $obra->update([
                    'id_tip_obr' => $request->input('idtipobr')
                ]);
            }

            if($request->input('plazo')){
                $obra->update([
                    'plazo' => $request->input('plazo')
                ]);
            }

            if($request->input('idope')){
                $obra->update([
                    'id_ope' => $request->input('idope')
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
            $id_obr = $obra->id_obr;

            //Crear la etapa
            $etapa = Ob_etapa::create([
                'id_obr' => $id_obr,
                'nro_eta' => 1,
                'descripcion' => strtoupper($request->input('descrip')),
                'can_viv_0' => 0,
                'can_viv_2' => 0,
                'can_viv_3' => 0,
                'can_viv_4' => 0,
                'cant_viv' => $request->input('can_viv'),
                'id_localidad' => $request->input('idloc')
            ]);

            //Obtener la id de la etapa que se genero en la BD
            $id_etapa = $etapa->id_etapa;

            //Crear entrega
            $entrega = Ob_entrega::create([
                'id_eta' => $id_etapa,
                'num_ent' => 0,
                'cant_viv' => $request->input('can_viv'),
                'fec_ent' => null
            ]);

            //Obtener la id de la entrega que se genero en la BD
            $id_ent = $entrega->id_ent;

            //Crear las viviendas
            for ($i=1; $i <= $request->input('can_viv'); $i++) { 
                Ob_vivienda::create([
                    'orden' => $i,
                    'id_mun' => Localidad::where('id_loc', $request->input('idloc'))->first()->id_mun,
                    'id_ent' => $id_ent,
                    'id_loc' => $request->input('idloc')
                ]);
            }

            return redirect()->route('obravivienda.index')->with('mensaje','La obra se creo con exito.');
        } catch (\Exception $e) {
            //Ob_obra::find($id_obr)->delete();
            return redirect()->route('obravivienda.index')->with('error','La obra no se puedo crear.');
            //return $e->getMessage();
        }

        // return redirect()->route('obravivienda.index')->with('mensaje','La obra se creo con exito.');  
    }

    public function show($id)
    {
        $this->conectar();
        // $user = User::find(342);
        // $user->syncPermissions(["VER-TICKET", "CREAR-TICKET", "EDITAR-TICKET", "VER-ARCHIVOS", "VER-OBRAVIVIENDA", "CREAR-OBRAVIVIENDA", "EDITAR-OBRAVIVIENDA", "CARGAR-VIVIENDAS"]);
        $obra = Ob_obra::find($id);
        $viviendas = $this->todasLasViviendasDeUnaObra($obra);
        $viviendasTabla = [];
        foreach ($viviendas as $vivienda) {
            $vivs[] = $vivienda->id_viv;
        }

        if(count($viviendas) != 0){
            $viviendasTabla = Ob_vivienda::whereIn('id_viv', $vivs)->orderBy('orden')->get();
        }

        return view('Planificacion.Planificacion.Obravivienda.show', compact('obra', 'viviendas', 'viviendasTabla'));
    }
   
    public function edit(Request $request, $id)
    {
        $this->conectar();
        $obra = Ob_obra::find($id);
        // $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc'); 
        // $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        $Localidad = Localidad::orderBy('nom_loc')->get();
        $TipoObra = Ob_tip_obr::orderBy('tipo_obra')->pluck('tipo_obra','id_tip_obr');
        $Empresa = Empresa::orderBy('nom_emp')->get(); 
        $TipoOpe = ob_operatoria::where('certifica', 1)->orderBy('operatoria', 'asc')->pluck('operatoria', 'id_ope');
        // $TipoOpe = ob_operatoria::whereNotNull('operat_adm')->pluck('operat_adm', 'id_ope');
        return view('Planificacion.Planificacion.Obravivienda.editar', compact('obra', 'Localidad', 'Empresa', 'TipoOpe', 'TipoObra'));
    }
    
    public function update(Request $request, $id)
    { 
        
        $this->validate($request, [
            'id_obr' => 'required',
            'num_obr' => 'required|string',
            'nom_obra' => 'required|string',
            'idempresa' => 'required',
            'idloc' => 'required',
            'can_viv' => 'required',
        ], [
            'num_obr.required' => 'El campo Numero de obra es obligatorio.',
            'nom_obra.required' => 'El campo Obra es obligatorio.',
            // 'idempresa.min' => 'Seleccione una empresa valida.',
            // 'idloc.min' => 'Seleccione una provincia valida.',
            'can_viv.required' => 'El campo Cantidad de viviendas de obra es obligatorio.',
            'descrip.required' => 'El campo Descripcion de una etapa es obligatorio.',
        ]);
        $this->conectar();
        $obra = Ob_obra::find($id);

        if($obra->id_loc != $request->input('idloc')){
            $viviendas = $this->todasLasViviendasDeUnaObra($obra);
            $idloc = $request->input('idloc');
            foreach ($viviendas as $vivienda) {
                $laViv = Ob_vivienda::find($vivienda->id_viv);
                $laViv->update([
                    'id_loc' => $idloc,
                    'id_mun' => Localidad::where('id_loc', $idloc)->first()->id_mun,
                ]);
            }
        }

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

        if($request->input('idtipobr')){
            $obra->update([
                'id_tip_obr' => $request->input('idtipobr')
            ]);
        }

        if($request->input('idope')){
            $obra->update([
                'id_ope' => $request->input('idope')
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
        $this->conectar();
        $obra = Ob_obra::find($id);
        $viviendas = array();

        // select et.nro_eta, e.num_ent, v.* from ob_vivienda v
        // inner join ob_entrega e on v.id_ent = e.id_ent
        // inner join ob_etapa et on e.id_eta = et.id_etapa 
        // inner join ob_obra o on o.id_obr = et.id_obr where o.id_obr=11585 order by v.orden;

        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden,]);
                }
            }
        }
        // return collect($viviendasTabla)->sortBy('orden');
        // return $viviendasTabla->sortBy('orden');
        $viviendasTabla = $this->todasLasViviendasDeUnaObra($obra);

        foreach ($viviendasTabla as $viviendass) {
            $vivs[] = $viviendass->id_viv;
        }
        $totalDeVivReal = 0;
        if(count($viviendasTabla) != 0){
            $totalDeVivReal = count($vivs);
            $viviendasTabla = Ob_vivienda::whereIn('id_viv', $vivs)
                                         ->orderBy('orden', 'asc')
                                         ->orderBy('partida', 'asc')
                                        //  ->orderBy('plano', 'asc')
                                        //  ->take(10)
                                         ->get();
        }
        
        $viviendas = collect($viviendas);
        return view('Planificacion.Planificacion.Obravivienda.altaviv', compact('obra', 'viviendas', 'viviendasTabla', 'totalDeVivReal'));
    }

    public function viviendaDeObra($id){
        $this->conectar();
        return Ob_vivienda::find($id);
    }

    public function viviendaDeObraId($id){
        $this->conectar();
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
        $this->conectar();
        // return $request;
        $id_viv = $request->input('vivienda');
        $id_obr = $request->input('id_obr');

        // $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$id_viv]);

        // if (count(auth()->user()->getDirectPermissions()->where('name', 'EDITAR-VIVIENDACOMPROMETIDA')) != 1){
        //     if ($modif[0]->modif == 0) {
        //         return redirect()->route('obravivienda.viviendas', $id_obr)->with('error','La vivienda se encuentra comprometida.');
        //     }
        // }
        $vivienda = Ob_vivienda::find($id_viv);
        
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

        if($request->input('sup_fin')){
            $vivienda->update([
                'sup_fin' => $request->input('sup_fin')
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
        $this->conectar();
        $obra = Ob_obra::find($id);
        $viviendasTabla = $this->todasLasViviendasDeUnaObra($obra);
        $totalDeVivReal = count($viviendasTabla);
        return view('Planificacion.Planificacion.Obravivienda.altaeta', compact('obra', 'viviendasTabla', 'totalDeVivReal'));
    }

    public function nuevaEta($id){
        $this->conectar();
        $obra = Ob_obra::find($id);
        return view('Planificacion.Planificacion.Obravivienda.etapa.crear', compact('obra'));
    }

    public function guardarNuevaEta(Request $request){

        $this->validate($request, [
            'num_eta' => 'required',
            'descrip' => 'required'
        ], [
            'num_eta.required' => 'El campo Numero de etapa no puede estar vacio.',
            'descrip.required' => 'El campo Descripcion de etapa no puede estar vacio.',
        ]);
        $this->conectar();
        $id_obr = $request->input('id_obr');
        $nro_eta = $request->input('num_eta');
        $obra = Ob_obra::find($id_obr);

        $totalDeViviendas = $request->input('can_viv_2') + $request->input('can_viv_3') + $request->input('can_viv_4');

        //Comprobar si el numero de la etapa no esta en uso.
        $existeEtapa = Ob_etapa::where('id_obr', $id_obr)->where('nro_eta', $nro_eta)->first();
        if (isset($existeEtapa)){
            return redirect()->route('obravivienda.nuevaetapa', $id_obr)->with('error','El numero de etapa ya existe.'); 
        }else{
            Ob_etapa::create([
                'id_obr' => $id_obr,
                'nro_eta' => $nro_eta,
                'descripcion' => strtoupper($request->input('descrip')),
                'can_viv_0' => 0,
                'can_viv_2' => 0,
                'can_viv_3' => 0,
                'can_viv_4' => 0,
                'cant_viv' => 0,
                'id_localidad' => $obra->id_loc,
            ]);

            //Obtener la id de la etapa que se genero en la BD
            $id_etapa = Ob_etapa::where('id_obr', $id_obr)->where('nro_eta', $nro_eta)->first()->id_etapa;

            //Crear entrega
            $entrega = Ob_entrega::create([
                'id_eta' => $id_etapa,
                'num_ent' => 0,
                'cant_viv' => 0,
                'fec_ent' => null
            ]);
            return redirect()->route('obravivienda.etapas', $id_obr)->with('mensaje','La etapa se creo con exito.');
        }    
    }

    public function verEditarEta($id){
        $this->conectar();
        $etapa = Ob_etapa::find($id);
        return view('Planificacion.Planificacion.Obravivienda.etapa.editar', compact('etapa'));
    }

    public function editarEta(Request $request, $id){
        $this->validate($request, [
            'num_eta' => 'required',
            'descrip' => 'required',
        ]);
        $this->conectar();
        $nro_eta = $request->input('num_eta');

        $etapa = Ob_etapa::find($id);
        $existeEtapa = Ob_etapa::where('id_obr', $etapa->id_obr)->where('nro_eta', $nro_eta)->first();

        if (isset($existeEtapa) && $etapa->id_etapa != $existeEtapa->id_etapa){
            return redirect()->route('obravivienda.editaretapa', $etapa->id_etapa)->with('error','El numero de etapa ya existe.'); 
        }else{
            $etapa->update([
                'nro_eta' => $nro_eta,
                'descripcion' => strtoupper($request->input('descrip')),
                'can_viv_2' => $request->input('can_viv_2'),
                'can_viv_3' => $request->input('can_viv_3'),
                'can_viv_4' => $request->input('can_viv_4'),
            ]);
            return redirect()->route('obravivienda.etapas', $etapa->id_obr)->with('mensaje','La etapa se modifico con exito.');
        }
    }

    public function eliminarEta($id){
        $this->conectar();
        $etapa = Ob_etapa::find($id);
        $id_obr = $etapa->id_obr;

        if(count($etapa->getEntregas) == 0){
            $etapa->delete();
            return redirect()->route('obravivienda.etapas', $id_obr)->with('mensaje','La etapa se borro con exito.');
        }else{
            return redirect()->route('obravivienda.etapas', $id_obr)->with('error','La etapa ya tiene una entrega asociada.');
        }    
    }

    public function verNuevaEnt($id)
    {
        $this->conectar();
        $obra = Ob_obra::find($id);
        $etapas = $obra->getEtapas->pluck('nro_eta','id_etapa');
        $todasLasEntregas = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                array_push($todasLasEntregas, $entrega->num_ent);
            }
        }
        // return count($todasLasEntregas);
        return view('Planificacion.Planificacion.Obravivienda.entrega.crear', compact('etapas', 'obra', 'todasLasEntregas'));
    }

    public function guardarNuevaEnt(Request $request)
    {

        $this->validate($request, [
            'num_ent' => 'required',
            'descrip' => 'required',
            'idetapa' => 'required'
        ], [
            'num_ent.required' => 'El campo Numero de entrega no puede estar vacio.',
            'descrip.required' => 'El campo Descripcion de la entrega no puede estar vacio',
            'idetapa' => 'Seleccione una etapa a la que corresponda la entrega.'
        ]);
        $this->conectar();
        // return $request;
        $id_obr = $request->input('id_obr');
        $num_ent = $request->input('num_ent');
        $obra = Ob_obra::find($id_obr);

        if (in_array($num_ent, $this->numeroEntregaUso($obra))) {
            return redirect()->route('obravivienda.vernuevaentrega', $id_obr)->with('error','El numero de entrega ya esta en uso.');
        } else {
            if($request->input('fec_ent')){
                Ob_entrega::create([
                    'id_eta' => $request->input('idetapa'),
                    'num_ent' => $request->input('num_ent'),
                    'descripcion' => $request->input('descrip'),
                    'fec_ent' => $request->input('fec_ent'),
                    'cant_viv' => 0,
                ]);
            }else{
                Ob_entrega::create([
                    'id_eta' => $request->input('idetapa'),
                    'num_ent' => $request->input('num_ent'),
                    'descripcion' => $request->input('descrip'),
                    'cant_viv' => 0,
                ]);
            }
    
            return redirect()->route('obravivienda.etapas', $id_obr)->with('mensaje','La entrega se creo con exito.');
        }
    }

    public function verEditarEnt($id, $idobra){
        $this->conectar();
        $entrega = Ob_entrega::find($id);
        $obra = Ob_obra::find($idobra);
        $etapas = $obra->getEtapas->pluck('nro_eta','id_etapa');
        return view('Planificacion.Planificacion.Obravivienda.entrega.editar', compact('entrega', 'etapas', 'obra'));
    }

    public function editarEnt(Request $request, $id){
        // return $request;
        $this->validate($request, [
            'num_ent' => 'required',
            'descrip' => 'required',
            'idetapa' => 'required'
        ]);
        $this->conectar();
        $nro_ent = $request->input('num_ent');
        $id_obr = $request->input('id_obr');

        $entrega = Ob_entrega::find($id);
        $existeEntrega = Ob_entrega::where('id_eta', $entrega->id_eta)->where('num_ent', $nro_ent)->first();

        if (isset($existeEntrega) && $entrega->id_ent != $existeEntrega->id_ent){
            return redirect()->route('obravivienda.editarentrega', [$entrega->id_ent, $id_obr])->with('error','El numero de entrega ya existe.'); 
        }else{
            $entrega->update([
                'id_eta' => $request->input('idetapa'),
                'num_ent' => $request->input('num_ent'),
                'descripcion' => strtoupper($request->input('descrip')),
                'cant_viv' => $request->input('cant_viv')
            ]);

            if($request->input('fec_ent')){
                $entrega->update([
                    'fec_ent' => $request->input('fec_ent')
                ]);
            }

            return redirect()->route('obravivienda.etapas', $id_obr)->with('mensaje','La entrega se modifico con exito.');
        }
    }

    public function eliminarEnt($id){
        $this->conectar();
        $entrega = Ob_entrega::find($id);
        $id_obr = $entrega->getEtapa->id_obr;

        if(count($entrega->getViviendas) == 0){
            $entrega->delete();
            return redirect()->route('obravivienda.etapas', $id_obr)->with('mensaje','La entrega se borro con exito.');
        }else{
            return redirect()->route('obravivienda.etapas', $id_obr)->with('error','La entrega ya tiene una o varias viviendas asociadas.');
        }    
    }

    public function asignarVivEnt($id, $entrega){
        $this->conectar();
        $obra = Ob_obra::find($id);
        $listaViviendas = array();
        $viviendaDeEntrega = Ob_vivienda::where('id_ent', $entrega)->get();
        $todasLasViviendas = array();

        $entre = Ob_entrega::find($entrega);
        $etapa = Ob_etapa::find($entre->id_eta);
        foreach($obra->getEtapas->where('nro_eta', $etapa->nro_eta) as $etapa){
            foreach($etapa->getEntregas->where('num_ent', 0) as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
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
        $this->conectar();
        $obra = Ob_obra::find($id); 
        $viviendas = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendas, (object)[
                        'orden' => $vivienda->orden,
                        'etapa' => $etapa->nro_eta,
                        'entrega' => $entrega->num_ent,
                        'plano' => $vivienda->plano,
                        'seccion' => $vivienda->seccion,
                        'chacra' => $vivienda->chacra,
                        'manzana' => $vivienda->manzana,
                        'man_emp' => $vivienda->man_emp,
                        'nom_cal' => $vivienda->nom_cal,
                        'entrecalles' => $vivienda->entrecalles,
                        'municipio' => $vivienda->getMunicipio->nom_municipio,
                        'departamento' => $vivienda->getMunicipio->getDepartamento->nom_dep]);
                }
            }
        }
        $municipios = Municipios::orderBy('nom_municipio')->pluck('nom_municipio', 'id_municipio');
        $viviendas = collect($viviendas)->sortBy('orden');
        $totalViviendas = count($this->todasLasViviendasDeUnaObra($obra));
        return view('Planificacion.Planificacion.Obravivienda.cargamasiva', compact('obra', 'viviendas', 'totalViviendas', 'municipios'));
    }

    public function guardarCargaMasiva(Request $request, $id){
        
        $this->validate($request, [
            'ordenDesde' => 'required',
            'ordenHasta' => 'required',
        ]);
        $this->conectar();
        $desde = $request->input('ordenDesde');
        $hasta = $request->input('ordenHasta');
        $obra = Ob_obra::find($id);
        
        if($hasta <= $desde){
            return redirect()->route('obravivienda.cargamasiva', $obra->id_obr)->with('error','El numero de orden hasta debe ser mayor al numero orden desde.');
        }else{
            // if (count(auth()->user()->getDirectPermissions()->where('name', 'EDITAR-VIVIENDACOMPROMETIDA')) != 1){
            //     foreach($obra->getEtapas as $etapa){
            //         foreach($etapa->getEntregas as $entrega){
            //             foreach ($entrega->getViviendas as $vivienda) {
            //                 $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$vivienda->id_viv]);
            //                 if ($modif[0]->modif == 0) {
            //                     return redirect()->route('obravivienda.viviendas', $obra)->with('error','Una o varias viviendas se encuentra comprometida en una convocatoria.');
            //                 }
            //             }
            //         }
            //     }
            // }
            
            foreach($obra->getEtapas as $etapa){
                foreach($etapa->getEntregas as $entrega){
                    foreach ($entrega->getViviendas as $vivienda) {
                        if($vivienda->orden >= $desde && $vivienda->orden <= $hasta){
    
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

                            if($request->input('muni')){
                                $vivienda->update([
                                    'id_mun' => $request->input('muni')
                                ]);
                            }
    
                        }
                    }
                }
            }
            return redirect()->route('obravivienda.cargamasiva', $obra->id_obr)->with('mensaje','Las viviendas cargadas con exito.');
        }    
    }

    public function buscarViviendaOrden($orden, $idobra){
        $this->conectar();
        $obra = Ob_obra::find($idobra);
        $todasLasViviendas = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas->where('num_ent', 0) as $entrega){
                foreach ($entrega->getViviendas->where('orden', '=', $orden) as $vivienda) {
                    return $vivienda;
                }
            }
        }
        
        return response(['message' => 'No se encuentra.']);
    }

    public function todasLasViviendas($id){
        $this->conectar();
        $obra = Ob_obra::find($id);
        $todasLasViviendas = array();

        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas->where('num_ent', 0) as $entrega){
                foreach ($entrega->getViviendas as $vivienda) {
                    array_push($todasLasViviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden]);
                }
            }
        }
        return $todasLasViviendas;
    }

    public function todasLasViviendasDeUnaEtapa($id){
        $this->conectar();
        $etapa = Ob_etapa::find($id);
        $todasLasViviendas = array();

        
        foreach($etapa->getEntregas->where('num_ent', 0) as $entrega){
            foreach ($entrega->getViviendas as $vivienda) {
                array_push($todasLasViviendas, (object)[
                    'id_viv' => $vivienda->id_viv,
                    'orden' => $vivienda->orden]);
            }
        }
        return count($todasLasViviendas);
    }

    public function asignarViviendas(Request $request, $id, $ideta){
        $this->conectar();
        try {
            $entregaCero = Ob_entrega::where('id_eta', $ideta)->where('num_ent', 0)->first()->id_ent;
        } catch (\Throwable $th) {
            $entregaCero = Ob_entrega::where('id_eta', $ideta)->where('num_ent', 1)->first()->id_ent;
        }
        
        $etapa = Ob_etapa::find($ideta);

        if(empty($request->input('vivs'))){
            
            $viviendas = Ob_vivienda::where('id_ent', '=', $id)->get();

            foreach($viviendas as $vivienda){
               $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$vivienda->id_viv]);
               if($modif[0]->modif == 0){
                    return redirect()->route('obravivienda.entrega', [$etapa->id_obr, $id])->with('error','Una o varias viviendas de esta entrega se encuentra comprometida en una convocatoria.');
               }
            }
            
            foreach($viviendas as $vivienda){
                $vivienda->update([
                    'id_ent' => $entregaCero
                ]);
            }

        }else{
            $viviendas = $request->input('vivs');
            $total = count($viviendas);
            
            $viviendasAsignadas = Ob_vivienda::where('id_ent', $id)->get();

            if($viviendasAsignadas->isEmpty()){

                for ($i=0; $i < $total; $i++) { 
                    $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$viviendas[$i]]);
                    
                    if($modif[0]->modif == 0){
                         return redirect()->route('obravivienda.entrega', [$etapa->id_obr, $id])->with('error','Una o varias viviendas de esta entrega se encuentra comprometida en una convocatoria.');
                    }
                }

                for ($i=0; $i < $total; $i++) { 
                    $vivienda = Ob_vivienda::find($viviendas[$i]);
                    $vivienda->update([
                        'id_ent' => $id
                    ]);
                }

            }else{
    
                foreach($viviendasAsignadas as $viviendaAsignada){
                    $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$viviendaAsignada->id_viv]);
                    if($modif[0]->modif == 0){
                         return redirect()->route('obravivienda.entrega', [$etapa->id_obr, $id])->with('error','Una o varias viviendas de esta entrega se encuentra comprometida en una convocatoria.');
                    }
                }

                for ($i=0; $i < $total; $i++) { 
                    $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$viviendas[$i]]);
                    if($modif[0]->modif == 0){
                         return redirect()->route('obravivienda.entrega', [$etapa->id_obr, $id])->with('error','Una o varias viviendas de esta entrega se encuentra comprometida en una convocatoria.');
                    }
                }

                foreach ($viviendasAsignadas as $viviendaAsignada) { 
                    if(!in_array($viviendaAsignada->id_viv, $viviendas)){
                        $viviendaAsignada->update([
                            'id_ent' => $entregaCero
                        ]);
                    }
                }

                for ($i=0; $i < $total; $i++) { 
                    $vivienda = Ob_vivienda::find($viviendas[$i]);
                    $vivienda->update([
                        'id_ent' => $id
                    ]);
                }
            }
            
        }
        return redirect()->route('obravivienda.entrega', [$etapa->id_obr, $id])->with('mensaje','Se asigno las viviendas con exito.');
    }

    public function verNuevaViv($id){
        $this->conectar();
        $obra = Ob_obra::find($id);
        $ultimoOrden = 1;
        $viviendas = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden,]);
                }
            }
        }
        $viviendas = collect($viviendas);
        try {
            $ultimoOrden = $viviendas->sortBy('orden')->last()->orden + 1;
        } catch (\Throwable $th) {
            $ultimoOrden = 1;
        }
        
        return view('Planificacion.Planificacion.Obravivienda.vivienda.crear', compact('obra', 'ultimoOrden'));
    }

    public function verNuevaVivAlt($id){
        $this->conectar();
        $obra = Ob_obra::find($id);
        $ultimoOrden = 1;
        $viviendas = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendas, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden,]);
                }
            }
        }
        $viviendas = collect($viviendas);
        try {
            $ultimoOrden = $viviendas->sortBy('orden')->last()->orden + 1;
        } catch (\Throwable $th) {
            $ultimoOrden = 0;
        }
        
        return view('Planificacion.Planificacion.Obravivienda.vivienda.crearAlt', compact('obra', 'ultimoOrden'));
    }

    public function editarViv($viv, $obra){
        $this->conectar();
        $obra = Ob_obra::find($obra);
        $vivienda = Ob_vivienda::find($viv);
        $entregaActual = Ob_entrega::find($vivienda->id_ent);
        $etapaActual = Ob_etapa::find($entregaActual->id_eta)->id_etapa;
        $municipios = Municipios::orderBy('nom_municipio')->pluck('nom_municipio','id_municipio');
        $estado = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$viv]);

        if($estado[0]->modif || count(auth()->user()->getDirectPermissions()->where('name', 'EDITAR-VIVIENDACOMPROMETIDA')) == 1){
            $edita= '';
        }else{
            $edita= 'disabled';
        }
        return view('Planificacion.Planificacion.Obravivienda.vivienda.editar', compact('vivienda', 'obra', 'etapaActual', 'municipios', 'estado', 'edita'));
    }

    public function updateViv(Request $request, $viv, $obra){
        
        $this->conectar();
        
        // $modif = DB::select('SELECT iprodha.fun_modifica_idviv(?) as modif from dual', [$viv]);
        $this->updateVivienda($request, $viv);
        return redirect()->route('obravivienda.viviendas', $obra)->with('mensaje','La vivienda se modifico con exito.');

        // if (count(auth()->user()->getDirectPermissions()->where('name', 'EDITAR-VIVIENDACOMPROMETIDA')) == 1) {
        //     $this->updateVivienda($request, $viv);
        //     return redirect()->route('obravivienda.viviendas', $obra)->with('mensaje','La vivienda se modifico con exito.');
        // } else {
        //     if ($modif[0]->modif == 0) {
        //         return redirect()->route('obravivienda.viviendas', $obra)->with('error','La vivienda se encuentra comprometida en una convocatoria.');
        //     }else{
        //         $this->updateVivienda($request, $viv);
        //         return redirect()->route('obravivienda.viviendas', $obra)->with('mensaje','La vivienda se modifico con exito.');
        //     }
        // }
        

        // if($modif[0]->modif == 0 || auth()->user()->can('EDITAR-OBRAVIVIENDA')){
        //     return 'verdadero';
        //     return redirect()->route('obravivienda.viviendas', $obra)->with('error','La vivienda se encuentra comprometida en una convocatoria.');
        // }
        // else{
        //     return 'falso';
            
        // }
        
    }

    public function updateVivienda($request, $viv){
        $vivienda = Ob_vivienda::find($viv);

        if($request->input('orden')){
            $vivienda->update([
                'orden' => $request->input('orden')
            ]);
        }

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

        if(!is_null($request->input('muni'))){
            $vivienda->update([
                'id_mun' => $request->input('muni')
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
        
        if($request->input('edif')){
            $vivienda->update([
                'edificio' => $request->input('edif')
            ]);
        }

        if($request->input('piso')){
            $vivienda->update([
                'piso' => $request->input('piso')
            ]);
        }

        if($request->input('depto')){
            $vivienda->update([
                'departamento' => $request->input('depto')
            ]);
        }

        if($request->input('esca')){
            $vivienda->update([
                'escalera' => $request->input('esca')
            ]);
        }

        if($request->input('unfun')){
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

        if($request->input('sup_fin')){
            $vivienda->update([
                'sup_fin' => $request->input('sup_fin')
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

        // return redirect()->route('obravivienda.viviendas', $obra)->with('mensaje','La vivienda se modifico con exito.');
    }

    public function guardarNuevaViv(Request $request, $id){
        // return $request;
        $this->validate($request, [
            'etapa' => 'required',
            'orden' => 'required|numeric|min:1'
        ], [
            'etapa.required' => "Seleccione la etapa.",
            'orden.required' => 'El campo numero de orden no puede estar vacio.',
            'orden.min' => 'El numero de orden debe ser mayor o igual a 1.'
        ]);

        $this->conectar();
        $obra = Ob_obra::find($id);
        $ordenExiste = $this->numeroOrdenUsoViviendas($obra);
        $id_etapa = $request->input('etapa');
        $orden = $request->input('orden');

        if (in_array($orden, $this->numeroOrdenUsoViviendas($obra))){

            return redirect()->route('obravivienda.nuevaviv', $obra->id_obr)->with('error','El numero de orden ('.$orden.') de vivienda ya esta en uso en esta obra.');

        }else{

            $etapa = Ob_etapa::find($id_etapa);
            
            try {
                $id_ent = $etapa->getEntregas->where('num_ent', 0)->first()->id_ent;
            } catch (\Throwable $th) {
                $id_ent = $etapa->getEntregas->where('num_ent', 1)->first()->id_ent;
            }

            Ob_vivienda::create([
                'id_ent' => $id_ent,
                'id_mun' => Localidad::where('id_loc', $obra->id_loc)->first()->id_mun,
                'orden' => $orden,
                'id_loc' => $obra->id_loc
            ]);
    
            $vivienda = Ob_vivienda::where('id_ent', $id_ent)->where('orden', $orden)->first();
    
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
    
            if($request->input('sup_fin')){
                $vivienda->update([
                    'sup_fin' => $request->input('sup_fin')
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
    
            return redirect()->route('obravivienda.etapas', $obra->id_obr)->with('mensaje','La vivienda se creo con exito.');
        }
    }

    public function guardarNuevaVivAlt(Request $request, $id){
        // return $request;
        $this->validate($request, [
            'etapa' => 'required',
            'orden' => 'numeric|min:0'
        ], [
            'etapa.required' => "Seleccione la etapa.",
            'orden.min' => 'El numero de orden debe ser mayor o igual a 1.'
        ]);

        $this->conectar();
        $obra = Ob_obra::find($id);

        // $ordenExiste = $this->numeroOrdenUsoViviendas($obra);

        $id_etapa = $request->input('etapa');

        if($request->input('orden')){
            $orden = $request->input('orden');
        }else{
            $orden = 0;
        }

        

        // if (in_array($orden, $this->numeroOrdenUsoViviendas($obra))){

        //     return redirect()->route('obravivienda.nuevaviv', $obra->id_obr)->with('error','El numero de orden ('.$orden.') de vivienda ya esta en uso en esta obra.');

        // }else{

            $etapa = Ob_etapa::find($id_etapa);

            try {
                $id_ent = $etapa->getEntregas->where('num_ent', 0)->first()->id_ent;
            } catch (\Throwable $th) {
                $id_ent = $etapa->getEntregas->where('num_ent', 1)->first()->id_ent;
            }

            $vivienda = Ob_vivienda::create([
                'id_ent' => $id_ent,
                'id_mun' => Localidad::where('id_loc', $obra->id_loc)->first()->id_mun,
                'id_loc' => $obra->id_loc
            ]);
    
            // $vivienda = Ob_vivienda::where('id_ent', $id_ent)->where('orden', $orden)->first();
    
            if($request->input('orden')){
                $vivienda->update([
                    'orden' => $request->input('orden')
                ]);
            }

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
    
            if($request->input('sup_fin')){
                $vivienda->update([
                    'sup_fin' => $request->input('sup_fin')
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
    
            return redirect()->route('obravivienda.viviendas', $obra->id_obr)->with('mensaje','La vivienda se creo con exito.');
        // }
    }

    public function todasLasViviendasDeUnaObra(Ob_obra $obra){
        $viviendasTabla = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendasTabla, (object)[
                        'id_viv' => $vivienda->id_viv,
                        'orden' => $vivienda->orden,
                        'etapa' => $etapa->nro_eta,
                        'entrega' => $entrega->num_ent,
                        'discap' => $vivienda->discap,
                        'partida' => $vivienda->partida,
                        'plano' => $vivienda->plano,
                        'seccion' => $vivienda->seccion,
                        'chacra' => $vivienda->chacra,
                        'manzana' => $vivienda->manzana,
                        'parcela' => $vivienda->parcela,
                        'finca' => $vivienda->finca,
                        'sup_fin' => $vivienda->sup_fin,
                        'sup_lot' => $vivienda->sup_lot,
                        'num_cal' => $vivienda->num_cal,
                        'nom_cal' => $vivienda->nom_cal,
                        'latitud' => $vivienda->latitud,
                        'longitud' => $vivienda->longitud,
                        'edificio' => $vivienda->edificio,
                        'piso' => $vivienda->piso,
                        'departamento' => $vivienda->departamento,
                        'escalera' => $vivienda->escalera,
                        'uni_fun' => $vivienda->uni_fun]);
                }
            }
        }
        return $viviendasTabla = collect($viviendasTabla)->sortBy('orden');
    }

    public function numeroOrdenUsoViviendas(Ob_obra $obra){
        $viviendasTabla = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
                    array_push($viviendasTabla, $vivienda->orden);
                }
            }
        }
        return $viviendasTabla;
    }

    public function numeroEntregaUso(Ob_obra $obra){
        $listaNumEntrega = array();
        foreach($obra->getEtapas as $etapa){
            foreach($etapa->getEntregas as $entrega){
                array_push($listaNumEntrega, $entrega->num_ent);     
            }
        }
        return $listaNumEntrega;
    }

    public function pdfViviendas($id, $opcion, $ident, $ideta){
        $this->conectar();
        $pdf = app('dompdf.wrapper');
        $id = base64url_decode($id);
        $fecha = Carbon::now()->format('d-m-Y');
        $obra = Ob_obra::find($id);
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);
        
        $viviendasTabla = [];
        $etapa = null;
        $entrega = null;

        if($opcion){
            $viviendas = $this->todasLasViviendasDeUnaObra($obra);

            foreach ($viviendas as $vivienda) {
                $vivs[] = $vivienda->id_viv;
            }
    
            if(count($viviendas) != 0){
                $viviendasTabla = Ob_vivienda::whereIn('id_viv', $vivs)->orderBy('orden')->orderBy('partida')->get();
            }
        }else{
            $ident = base64url_decode($ident);
            $ideta = base64url_decode($ideta);
            $viviendasTabla = Ob_vivienda::where('id_ent', $ident)->orderBy('orden')->get();
            $etapa = Ob_etapa::find($ideta);
            $entrega = Ob_entrega::find($ident);
        }

        return $pdf->loadView('Planificacion.Planificacion.Obravivienda.informes.info-viviendas-pdf',[
                    'obra' => $obra,
                    'texto'=> $texto,
                    'viviendas' => $viviendasTabla,
                    'etapa' => $etapa,
                    'entrega' => $entrega,
                    'fecha' => $fecha
                    ])  ->setPaper('legal', 'landscape')
                        ->stream('Info-viviendas.pdf');
    }
}