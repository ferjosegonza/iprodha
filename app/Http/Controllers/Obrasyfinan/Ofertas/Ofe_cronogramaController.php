<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $plazo = Ofe_obra::where('idobra', '=', decrypt($id))->first()->plazo;
        $items = Ofe_item::where('idobra', '=', decrypt($id))->orderBy('iditem')->pluck('nom_item', 'iditem')->prepend('Seleccionar...', '0')->toArray();
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
        
        if(!empty($elItem)){
            return $elItem->poravaacuitem;
        }else{
            return 0;
        }
    }
}