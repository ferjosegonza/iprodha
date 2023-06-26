<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_item;

use App\Models\Iprodha\Localidad;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Ob_tipoitem;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_obraController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Ofe_itemController extends Controller
{
    public function index(Request $request)
    {
        // esta funcion casi no se utiliza ya que desde el index de la obra llamo a itemsoferta//
        $itemsxobra =Ofe_item::orderBy('iditem', 'asc')->simplePaginate(10);
        return view('Obrasyfinan.Ofertas.ofeitems.index',compact('itemsxobra'));
    }

    public function create($idobra)
    {
        $laObra = Ofe_obra::find($idobra);
        $tipoItem = Ob_tipoitem::pluck('dentipoitem','idtipoitem');
        return view('Obrasyfinan.Ofertas.ofeitems.crear',compact('laObra', 'tipoItem'));
    } 

    public function edit($itemId)
    {
        $unItem = Ofe_item::find(base64url_decode($itemId));
        $laObra =$unItem->getObra;
        $tipoItem = Ob_tipoitem::pluck('dentipoitem','idtipoitem');
        return view('Obrasyfinan.Ofertas.ofeitems.editar',compact('unItem','laObra', 'tipoItem'));
    }

    public function itemsxoferta ($idobra){
        
        $laObra = Ofe_obra::find(base64url_decode($idobra));
        $itemsxobra =  $laObra->getItems ;
        return view('Obrasyfinan.Ofertas.ofeitems.index',compact('laObra','itemsxobra'));
    } 

    public function store(Request $request)
    {
        $this->validate($request, [
            'nom_item' => 'required|min:5|max:80|string',
            'orden' => 'required|min:1|integer',
            'costo' => 'required|min:0|numeric',
            'por_inc' => 'required|min:0|numeric',          
            'cod_tipo' => 'required'     
        ]);

        $existeOrden = Ofe_item::where('idobra', '=', $request->input('idobra'))->where('orden', '=', $request->input('orden'))->get();
        
        if(sizeof($existeOrden)){
            return redirect()->route('ofeobraitems.crear', $request->input('idobra'))->with('error','El numero de orden ya existe.');
        }else{
            $itemOferta = Ofe_item::create([
                'idobra' => $request->input('idobra'),
                'nom_item' => strtoupper($request->input('nom_item')),
                'costo' => $request->input('costo'),
                'por_inc' => $request->input('por_inc'),
                'orden' => $request->input('orden'),
                'codigo' => 1,
                'cod_tipo' => $request->input('cod_tipo'),
            ]);
            return redirect()->route('ofeobraitems.itemsoferta',base64url_encode($itemOferta->idobra));
        } 
    }

    public function update(Request $request, $idItem)
    {
        $this->validate($request, [
            'orden' => 'required|min:1|integer',
            'nom_item' => 'required|min:5|max:80|string',
            'costo' => 'required|min:0|numeric',
            'por_inc' => 'required|min:0|numeric',        
            'cod_tipo' => 'required'       
        ]);

        $existeOrden = Ofe_item::where('idobra', '=', $request->input('idobra'))->where('orden', '=', $request->input('orden'))->where('iditem', '!=', $request->input('iditem'))->get();
        
        if(sizeof($existeOrden)){
            return redirect()->route('ofeobraitems.edit', $request->input('iditem'))->with('error','El numero de orden ya existe.');
        }else{
            $unItem = Ofe_item::find($idItem);
            $idobra = $unItem->getObra->idobra;
            $unItem->update([
                'nom_item' => strtoupper($request->input('nom_item')),
                'orden' => $request->input('orden'),
                'cod_tipo' => $request->input('cod_tipo'),
            ]);
            return redirect()->route('ofeobraitems.itemsoferta', base64url_encode($idobra));
        }
    }
    public function destroy($itemId)
    {   
        $unItem = Ofe_item::find($itemId);
        $idobra =$unItem->getObra->idobra;
        
        if(  sizeof($unItem->getSubItems) || sizeof($unItem->getCronograma)){
            return redirect()->route('ofeobraitems.itemsoferta', base64url_encode($idobra)  )->with('error','El item se encuentra en Cronogramas o posee Subitems. Debe eliminarlos para continuar');
        }else{
            $unItem->delete(); 
            return redirect()->route('ofeobraitems.itemsoferta', base64url_encode($idobra) )->with('mensaje','¡Item borrado con éxito!');
        }
        
    }
}
