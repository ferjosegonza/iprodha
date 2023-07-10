<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_item;
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Ofe_unidad;
use App\Models\Iprodha\Unidad;
use App\Models\Iprodha\Empresa;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemdetController;
use Illuminate\Support\Facades\Crypt;
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
        $unItem = Ofe_item::find(base64url_decode($idItem));
        $subitemxitem = Ofe_subitem::where('iditem', $unItem->iditem)->get();
        $unaObra = $unItem->getObra;
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.index', compact('subitemxitem','unItem','unaObra'));
    }  

    public function create($id)
    {  
        $unItem = Ofe_item::find(base64url_decode($id));
        $lasUnidades = Unidad::pluck('unidad','id_unidad'); 
        return view('Obrasyfinan.Ofertas.ofeitemsubitem.crear',compact('unItem','lasUnidades'));
    }

    public function edit($id)
    {
        $unSubItem = Ofe_subitem::find(base64url_decode($id));

        $unItem = Ofe_item::find($unSubItem->iditem);

        $lasUnidades = Unidad::pluck('unidad','id_unidad'); 

        return view('Obrasyfinan.Ofertas.ofeitemsubitem.editar',compact('unSubItem','unItem','lasUnidades'));
    }   
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'denominacion' => 'required|min:5|max:150|string',
            'unidad' => 'required|min:1|integer',
            'cantidad' => 'required|min:1|numeric|between:0,9999.99', 
            'costounitario' => 'required',
        ], [
            'idunidad.required' => 'Seleccione la Unidad.',
        ]);

        $costo = str_replace( ['$', ','], '', $request->input('costounitario'));

        Ofe_subitem::create([
            'iditem' => $request->input('iditem'),
            'denominacion' => $request->input('denominacion'),
            'idunidad' => $request->input('unidad'),
            'cantidad' => $request->input('cantidad'),
            'costounitario' => $costo,
        ]);

        return redirect()->route('ofeobraitemdet.detalleitem', base64url_encode($request->input('iditem')))->with('mensaje','El sub-item fue creado con exito.');
    } 

    public function destroy($id)
    {
        $unSubItem = Ofe_subitem::find($id);
        $item = $unSubItem->iditem;

        $unSubItem->delete();
        return redirect()->route('ofeobraitemdet.detalleitem', base64url_encode($item))->with('mensaje','El sub-item fue borrado con éxito!.');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'denominacion' => 'required|min:5|max:150|string',
            'unidad' => 'required|min:1|integer',
            'cantidad' => 'required|min:1|numeric|between:0,9999.99', 
            'costounitario' => 'required',
        ], [
            'idunidad.required' => 'Seleccione la Unidad.',
        ]);

        $costo = str_replace( ['$', ','], '', $request->input('costounitario'));
        //busco el subitem para sobreescribirlo
        $subItem = Ofe_subitem::find($id);
        
        //Se actualizan todos los datos
        $subItem->update([
            'denominacion' => $request->input('denominacion'),
            'idunidad' => $request->input('unidad'),
            'cantidad' => $request->input('cantidad'),
            'costounitario' => $costo,
        ]);

        return redirect()->route('ofeobraitemdet.detalleitem', base64url_encode($request->input('iditem')))->with('mensaje','El sub-item fue modificado con exito.'); 
    }
}
