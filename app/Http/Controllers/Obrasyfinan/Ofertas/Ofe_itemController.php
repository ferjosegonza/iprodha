<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_item;

use App\Models\Iprodha\Localidad;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Empresa;
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
        return view('Obrasyfinan.Ofertas.ofeitems.crear',compact('laObra'));
    }    
    public function edit($itemId)
    {
        $unItem = Ofe_item::find($itemId);
        $laObra =$unItem->getObra;
        return view('Obrasyfinan.Ofertas.ofeitems.editar',compact('unItem','laObra'));
    }
    public function itemsxoferta ($idobra){
        
        $laObra = Ofe_obra::find(decrypt($idobra));
        $itemsxobra =  $laObra->getItems ;
        return view('Obrasyfinan.Ofertas.ofeitems.index',compact('laObra','itemsxobra'));
    } 

    public function store(Request $request)
    {
        $validatedData = $request->validate([
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
            // $input = $request->all(); 
            $itemOferta = Ofe_item::create([
                'idobra' => $request->input('idobra'),
                'iditem' => $request->input('iditem'),
                'nom_item' => strtoupper($request->input('nom_item')),
                'costo' => $request->input('costo'),
                'por_inc' => $request->input('por_inc'),
                'orden' => $request->input('orden'),
                'codigo' => 1,
                'cod_tipo' => $request->input('cod_tipo'),
            ]);
            // $itemOferta = new Ofe_item;
            // $itemOferta->idobra = $request->input('idobra');
            // $itemOferta->iditem = $request->input('iditem');
            // $itemOferta->nom_item = strtoupper($request->input('nom_item'));
            // $itemOferta->costo = $request->input('costo');
            // $itemOferta->por_inc = $request->input('por_inc');
            // $itemOferta->orden = $request->input('orden');
            // $itemOferta->codigo = 1;
            // $itemOferta->cod_tipo = $request->input('cod_tipo');        
            // $itemOferta->save();
            return redirect()->route('ofeobraitems.itemsoferta',encrypt($itemOferta->idobra));
        } 
    }

    public function update(Request $request, $idItem)
    {
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
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
        $input = $request->all(); 
        $unItem = Ofe_item::find($idItem);
        $idobra =$unItem->getObra->idobra;  
        $unItem->idobra = $unItem->getObra->idobra;
        $unItem->iditem = $idItem;
        $unItem->nom_item = strtoupper($request->input('nom_item'));
        $unItem->costo = $request->input('costo');
        $unItem->por_inc = $request->input('por_inc');
        $unItem->orden = $request->input('orden');
        $unItem->codigo = 1;
        $unItem->cod_tipo = $request->input('cod_tipo');; 
        $unItem->save();
        return redirect()->route('ofeobraitems.itemsoferta',encrypt($idobra));}
    }
    public function destroy($itemId)
    {   
        $unItem = Ofe_item::find($itemId);
        // $subitems = $unItem->getSubItems;
        // $cronograma = $unItem->getCronograma;
        $idobra =$unItem->getObra->idobra;
        
        if(  sizeof($unItem->getSubItems) || sizeof($unItem->getCronograma)){
            return redirect()->route('ofeobraitems.itemsoferta', encrypt($idobra)  )->with('error','El item se encuentra en Cronogramas o posee Subitems. Debe eliminarlos para continuar');
        }else{
            $unItem->delete(); 
            return redirect()->route('ofeobraitems.itemsoferta', encrypt($idobra) )->with('mensaje','¡Item borrado con éxito!');
        }
        
    }
}