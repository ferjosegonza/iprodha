<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Tablero;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Vw_tablero_ge_recaudacion;

use App\Models\Iprodha\Vw_tc_re003_indice;
use App\Models\Iprodha\Vw_tc_re003_comparativointe;
use App\Models\Iprodha\Vw_tc_re003_ultimoindicador;
use App\Models\Iprodha\Vw_tc_re003_indicadorportipo;
use App\Models\Iprodha\Vw_tc_re003_rangos;
use App\Models\Iprodha\Vw_tc_re003_vigentedetalle;
use App\Models\Iprodha\Vw_tc_re003_vigente;




class Re003Controller extends Controller
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
    
    public function indice(){
        $data = Vw_tc_re003_indice::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function comparativointerior(){
        $data = Vw_tc_re003_comparativointe::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function ultimoindicador(){
        $data = Vw_tc_re003_ultimoindicador::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function indicadorportipologia(){
        $data = Vw_tc_re003_indicadorportipo::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function rangos(){
        $data = Vw_tc_re003_rangos::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function vigentedetalle(){
        $data = Vw_tc_re003_vigentedetalle::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function vigente(){
        $data = Vw_tc_re003_vigente::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
