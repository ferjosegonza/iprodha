<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//agregamos

use App\Models\Iprodha\Ofe_cronograma;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_item;
use App\Models\Iprodha\Vw_ofe_cronograma;

class Ofe_cronogramaController extends Controller
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
        return view('Obrasyfinan.Ofertas.ofecrono.index');
    }

    public function indexPorc(Request $request, $id)
    {     
        $id = base64url_decode($id);
        $losItems = DB::select('select orden, nom_item, por_inc, round((iprodha.fun_PorAcuCronoItem(iditem)*100)/por_inc, 2) AvaItemPor, CASE WHEN round((IPRODHA.fun_PorAcuCronoItem(iditem)*100)/por_inc, 2) >= 100 THEN 1 ELSE 0 END estado from iprodha.ofe_item where idobra = ? order by orden', [$id]);
        // $losItems = Ofe_item::where('idobra', $id)->orderBy('orden')->get();
        // return $losItems;
        $items = Ofe_item::where('idobra', '=', $id)->orderBy('iditem')->pluck('nom_item', 'iditem')->prepend('Seleccionar...', '0')->toArray();
        $plazo = Ofe_obra::where('idobra', $id)->first()->plazo;
        return view('Obrasyfinan.Ofertas.ofecrono.indexPorc', compact('losItems', 'plazo', 'items', 'id'));
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
        // return base64url_decode($id);
        $plazo = Ofe_obra::where('idobra', '=', base64url_decode($id))->first()->plazo;
        $items = Ofe_item::where('idobra', '=', base64url_decode($id))->orderBy('iditem')->pluck('nom_item', 'iditem')->prepend('Seleccionar...', '0')->toArray();
        return view('Obrasyfinan.Ofertas.ofecrono.index', compact('plazo', 'items', 'id'));
    }
    
    public function update(Request $request, $id)
    { 
                                      
    }

    public function destroy($id)
    {
          $cronoBorrar = Ofe_cronograma::find($id);
          $cronoBorrar->delete();
          return response(['message' => 'Deleted']);
    }

    public function losItems($obra, $mes)
    {
        $items = Vw_ofe_cronograma::where('idobra', '=', $obra)->where('mes', '=', $mes)->get();
        return $items;
    }

    public function unItem($obra, $item)
    {
        $unItem = Ofe_item::where('iditem', "=", $item)->where('idobra', '=', $obra)->get();
        return $unItem;
    }

    public function guardarCrono($mes, $item, $avance)
    {
        $nuevoCrono = Ofe_cronograma::create(['iditem' => $item, 'mes' => $mes, 'avance' => $avance]);
        // $unItem = Ofe_item::where('iditem', "=", $item)->where('idobra', '=', $obra)->get();
        // return $unItem;
        // $idCrono = Ofe_cronograma::orderBy('idcrono', 'desc')->first()->idcrono;
        // return $idCrono;
        // $nuevoCrono = new Ofe_cronograma();
        // $nuevoCrono->iditem = $item;
        // $nuevoCrono->mes = $mes;
        // $nuevoCrono->avance = $avance;
        // $nuevoCrono->save();
        return $nuevoCrono;
    }

    public function buscarItemMes($mes, $item)
    {
        $existeItem = Ofe_cronograma::where('mes', '=', $mes)->where('iditem', '=', $item)->first();

        if(empty($existeItem)){
            return 1;
        }else{
            return 0;
        }
    }

    public function comprobarAvance($item)
    {
        $elItem = Vw_ofe_cronograma::where('iditem', '=', $item)->first();
        // return $elItem;
        if(!empty($elItem)){
            return $elItem->poravaacuitem;
        }else{
            return 0;
        }
    }

    public function infoItem($item)
    {
        $elItem = Vw_ofe_cronograma::where('iditem', '=', $item)->first();
        // return $elItem;
        $incItem = Ofe_item::where('iditem', $item)->first();
        
        $infoItem = array();
        
        if(!empty($elItem)){
            array_push($infoItem, (object)['por_inc' => $elItem->por_inc,
                                        'avaTotal' => $elItem->poravaacuitem,
                                        'avaTotalPor' => $elItem->avaitempor
                                        ]);
        }else{
            array_push($infoItem, (object)['por_inc' => $incItem->por_inc,
                                        'avaTotal' => 0,
                                        'avaTotalPor' => 0
                                        ]);
        }
        return $infoItem;
    }
}