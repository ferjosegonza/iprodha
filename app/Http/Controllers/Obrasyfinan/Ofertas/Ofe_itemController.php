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
        $laObra = Ofe_obra::find($idobra);
        $itemsxobra =  $laObra->getItems ;
        return view('Obrasyfinan.Ofertas.ofeitems.index',compact('laObra','itemsxobra'));
    } 

   


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            'nom_item' => 'required|min:5|max:80|string',
            'costo' => 'required|min:1|integer',
            'por_inc' => 'required|min:1|integer',            
        ]);
        $input = $request->all(); 
        $itemOferta = new Ofe_item;
        $itemOferta->idobra = $request->input('idobra');
        $itemOferta->iditem = $request->input('iditem');        
        $itemOferta->nom_item = strtoupper($request->input('nom_item'));
        $itemOferta->costo = $request->input('costo');
        $itemOferta->por_inc = $request->input('por_inc');
        $itemOferta->orden = $request->input('orden');
        $itemOferta->codigo = 1;
        $itemOferta->cod_tipo = 1;        
        $itemOferta->save();
        
        return redirect()->route('ofeobraitems.itemsoferta',$itemOferta->idobra );
    }

    public function update(Request $request, $idItem)
    {
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            'nom_item' => 'required|min:5|max:80|string',
            'costo' => 'required|min:1|integer',
            'por_inc' => 'required|min:0|integer',            
        ]);
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
        $unItem->cod_tipo = 1; 
        $unItem->save();
        return redirect()->route('ofeobraitems.itemsoferta',$idobra);
    }
    public function destroy($itemId )
    {        
        $unItem = Ofe_item::find($itemId)->first();
        $idobra =$unItem->getObra->idobra;        
        $unItem->delete();        
        return redirect()->route('ofeobraitems.itemsoferta', $idobra );
    }
}
