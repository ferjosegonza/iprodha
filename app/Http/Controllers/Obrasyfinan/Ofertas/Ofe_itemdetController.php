<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_item;
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Ofe_unidad;

//use App\Models\Iprodha\Localidad;
//use App\Models\ME\Expediente;
use App\Models\Iprodha\Empresa;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemdetController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Ofe_itemdetController extends Controller
{
    public function index(Request $request)
    {
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.index');
    }
    public function detalleitem($idItem)
    { 
        $unItem = Ofe_item::find($idItem);
        $subitemxitem = Ofe_subitem::where('iditem','=' ,$unItem->iditem)->get();
        $unaObra = $unItem->getObra;
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.index', compact('subitemxitem','unItem','unaObra'));
    }    
    public function create($idItem)
    {        
        $unItem= Ofe_item::find($idItem);
        $lasUnidades = Ofe_unidad::pluck('unidad','idunidad'); 
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.crear',compact('unItem','lasUnidades'));
    }
    public function edit($unSubItem,$unItem)
    {
        $unSubItem = DB::table('iprodha.Ofe_subitem')
                    ->where('iditem','=', $unItem)
                    ->where('idsubitem','=', $unSubItem)
                    ->first();
        $unItem =Ofe_item::find($unItem);
        $lasUnidades = Ofe_unidad::pluck('unidad','idunidad'); 
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.editar',compact('unSubItem','unItem','lasUnidades'));
    }   
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            'denominacion' => 'required|min:5|max:80|string',
            'unidad' => 'required|min:1|integer',
            'cantidad' => 'required|min:1|integer', 
            'costounitario' => 'required|min:1|integer', 

        ]);
        $input = $request->all(); 
        $subitem = new Ofe_subitem;
        $subitem->idobra = $request->input('idobra');
        $subitem->iditem = $request->input('iditem');
        $subitem->idsubitem = $request->input('idsubitem');
        $subitem->denominacion = $request->input('denominacion');
        $subitem->unidad = $request->input('unidad');
        $subitem->cantidad = $request->input('cantidad');
        $subitem->costounitario = $request->input('costounitario');
        $subitem->save();
        return redirect()->route('ofeobraitemdet.detalleitem',$subitem->iditem );
    } 

    public function destroy($unSubItem,$unItem)
    {
        $unSubItem1 = DB::table('iprodha.Ofe_subitem')
        ->where('iditem','=', $unItem)
        ->where('idsubitem','=', $unSubItem)->delete();
        $item = DB::table('iprodha.Ofe_item')->where('iditem','=', $unItem)->first(); 
        $unSubItem1->delete(); 
        return redirect()->route('ofeobraitems.itemsoferta', $item->$idobra );
    }

    public function update(Request $request, $id)
    {
        
        $input  = $request->all(); 
        $validatedData = $request->validate([
            'denominacion' => 'required|min:5|max:80|string',
            'idunidad' => 'required|min:1|max:10|integer',
            'cantidad' => 'required|min:0|integer',
            'costounitario' => 'required|min:0|integer',
        ]);
        
        $idSubItem  = $request->input('idsubitem');
        $idItem = $request->input('iditem');
        //busco el subitem para sobreescribirlo
        $unSubItem1 = Ofe_subitem::where('iditem','=', $idItem)
        ->where('idsubitem','=', $idSubItem)->first();
                $unSubItem1->denominacion = $request->get('denominacion');
                $unSubItem1->idunidad = $request->get('idunidad');
                $unSubItem1->cantidad = $request->get('cantidad');
                $unSubItem1->costounitario = $request->input('costounitario');
                $unSubItem1->save();
        return redirect()->route('ofeobraitemdet.detalleitem',$idItem); 
    }
}
