<?php
namespace App\Http\Controllers\Terrenos;

use Illuminate\Http\Request;
use App\Models\Iprodha\Terrenos;
use App\Models\Iprodha\Municipios;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class TerrenosController extends Controller 
{
    public function index() {
        $terrenos = Terrenos::Paginate(200);
        return view('terrenos.index')->with('terrenos', $terrenos);
    }

    public function edit($id) 
    {
        $terreno = Terrenos::find($id);
        //$municipio = Municipios::where('id_municipio','=', $id);
        $municipios = Municipios::all();
        return view('terrenos.edit', compact('municipios', $municipios))->with('terreno', $terreno); 
    }

    public function destroy($id)
    {
        return redirect('/terrenos'); 
    }
}