<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Tablero;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Vw_tablero_ge_recaudacion;

use App\Models\Iprodha\Vw_tc_ju001_juicios;
use App\Models\Iprodha\Vw_tc_ju001_comparativo;
use App\Models\Iprodha\Vw_tc_ju001_detallebajas;
use App\Models\Iprodha\Vw_tc_ju001_detallealtas;
use App\Models\Iprodha\Vw_tc_ju001_ultimo;
use App\Models\Iprodha\Vw_tc_ju001_efectividad;
use App\Models\Iprodha\Vw_prueba;




class Ju001Controller extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarvista']]);
        //  $this->middleware('permission:CREAR-ROL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','updatevista']]);
        //  $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        return $data = Vw_tablero_ge_recaudacion::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    


    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {              
    }
    
    public function juicios(){
        $data = Vw_tc_ju001_juicios::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function comparativo(){
        $data = Vw_tc_ju001_comparativo::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function ultimo(){
        $data = Vw_tc_ju001_ultimo::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detallebajas(){
        $data = Vw_tc_ju001_detallebajas::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detallealtas(){
        $data = Vw_tc_ju001_detallealtas::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function efectividad(){
        $data = Vw_tc_ju001_efectividad::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
