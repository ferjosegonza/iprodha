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
use App\Models\Iprodha\Localidad;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Ob_item_costo;
use App\Models\Iprodha\Vw_ob_obras_modificables;
use App\Models\Iprodha\Vw_ob_items_obras_modificables;
//Gestion de usuario oracle
use App\Traits\ConectarUserDB;


class ItemObraController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:VER-OBRAVIVIENDA|CREAR-OBRAVIVIENDA|EDITAR-OBRAVIVIENDA|BORRAR-OBRAVIVIENDA', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);
    }

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
                    $obras = Vw_ob_obras_modificables::where('num_obr', 'like', '%'.$name.'%')
                            ->orWhere('nom_obr', 'like', '%' . strtoupper($name) . '%')
                            ->orWhere('expedte', 'like', '%' . strtoupper($name) . '%')
                            ->orderBy('num_obr','asc')->take(100)
                            ->get();
                    break;

                case 1:
                    $obras = Vw_ob_obras_modificables::where('num_obr', $name)
                                    ->take(100)
                                    ->get();
                    break;
                
                case 2:
                    $obras = Vw_ob_obras_modificables::where('nom_obr', 'like', '%' . strtoupper($name) . '%')
                                    ->orderBy('num_obr', 'desc')
                                    ->take(100)
                                    ->get();
                    break;

                case 3:
                    $obras = Vw_ob_obras_modificables::where('expedte', 'like', '%' . strtoupper($name) . '%')
                                    ->take(100)
                                    ->get();
                    break;

                case 4:

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
                        $obras = Vw_ob_obras_modificables::whereIn('id_obr', $vivs)->orderBy('num_obr', 'desc')->take(100)->get();
                    }

                    break;

                case 5:
                    $empresas = Empresa::where('nom_emp', 'like', '%' . strtoupper($name) . '%')->get();
                    foreach ($empresas as $empresa) {
                        $empid[] = $empresa->id_emp;
                    }

                    if (count($empresas) != 0) {
                        $obras = Vw_ob_obras_modificables::whereIn('id_emp', $empid)
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
                        $obras = Vw_ob_obras_modificables::whereIn('id_loc', $locid)
                                                ->orderBy('num_obr', 'asc')
                                                ->take(100)
                                                ->get();
                    }
                    break;

                default:
                    $obras = Vw_ob_obras_modificables::orderBy('id_obr', 'desc')->limit(20)->get();
                    break;
            }
             
        }else{
            $obras = Vw_ob_obras_modificables::orderBy('id_obr', 'desc')->limit(20)->get();
        }

        return view('Planificacion.Planificacion.Itemizado.index', compact('obras', 'opcion'));
    }

    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
         
    }

    public function show($id)
    {
        
    }
   
    public function edit(Request $request, $id)
    {
        $this->conectar();
        
        $obra = Ob_obra::find($id);

        $ItemsObra = Vw_ob_items_obras_modificables::where('id_obr', $id)->orderBy('orden')->get();

        return view('Planificacion.Planificacion.Itemizado.editar', compact('obra', 'ItemsObra'));
    }
    
    public function update(Request $request, $id)
    { 
        $ListaItemCosto = Ob_item_costo::where('id_obr', $id)->where('id_red', 0)->get();
        

        foreach ($ListaItemCosto as $itemCosto) {
            $costoNuevo = (float) $request->input('item-'.$itemCosto->id_item);

            DB::update('UPDATE iprodha.ob_item_costo SET costo=? WHERE id_obr=? and id_item=? and id_red=0', [$costoNuevo, $id, $itemCosto->id_item]);

        }

        return redirect()->route('itemizado_obra.edit', $id)->with('mensaje','Los items se modificaron con exito.');                               
    }

    public function destroy($id)
    {
          
    }
}