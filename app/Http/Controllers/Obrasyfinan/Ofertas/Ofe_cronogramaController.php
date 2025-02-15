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

        $losItems = DB::select('select i.idobra, i.iditem, i.orden, i.nom_item, i.por_inc, NVL(a.AvaItemPor, 0) AvaItemPor, CASE WHEN a.AvaItemPor >= 100 THEN 1 ELSE 0 END estado from iprodha.ofe_item i left join (select iditem, sum(porcentaje) AvaItemPor from iprodha.ofe_cronograma group by iditem) a on a.iditem = i.iditem where idobra = ? order by orden', [$id]);
        
        $items = Ofe_item::all()->where('idobra', '=', $id)->sortBy('orden')->pluck('orden_item', 'iditem')->prepend('Seleccionar...', '0')->toArray();
        // $items = Ofe_item::where('idobra', '=', $id)->orderBy('iditem')->pluck('orden_item', 'iditem')->prepend('Seleccionar...', '0')->toArray();
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
        $items = Vw_ofe_cronograma::where('idobra', '=', $obra)->where('mes', '=', $mes)->orderBy('orden')->get();
        return $items;
    }

    public function unItem($obra, $item)
    {
        $unItem = Ofe_item::where('iditem', "=", $item)->where('idobra', '=', $obra)->get();
        return $unItem;
    }

    public function guardarCrono($mes, $item, $avance, $porc)
    {
        // return $porc;
        $nuevoCrono = Ofe_cronograma::create(['iditem' => $item, 'mes' => $mes, 'avance' => $avance, 'porcentaje' => $porc]);
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

        $avaAcuItem = ofe_cronograma::where('iditem', $item)->sum('porcentaje');
        
        $infoItem = array();
        
        if(!empty($elItem)){
            array_push($infoItem, (object)['por_inc' => $elItem->por_inc,
                                        'avaTotal' => $elItem->poravaacuitem,
                                        'avaTotalPor' => $avaAcuItem
                                        ]);
        }else{
            array_push($infoItem, (object)['por_inc' => $incItem->por_inc,
                                        'avaTotal' => 0,
                                        'avaTotalPor' => 0
                                        ]);
        }
        return $infoItem;
    }

    public function limpiarAvanceITem($iditem){

        $cronoItem = ofe_cronograma::where('iditem', $iditem)->get();
        $cronoItem->each->delete();
        return back()->with('mensaje','Se limpio el avance del item.');
    }
}