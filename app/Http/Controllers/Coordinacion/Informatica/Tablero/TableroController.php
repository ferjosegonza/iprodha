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

use App\Models\Iprodha\Lav_tc_tablero;
use App\Models\Iprodha\Lav_tc_vista;



class TableroController extends Controller
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
        $tableros = Lav_tc_tablero::orderBy('nombre_tablero')->get();
        $vistas = Lav_tc_vista::orderBy('nombre_vista')->get();
        return view('Coordinacion.Informatica.Tablero.index', compact('tableros', 'vistas'));
    }
    


    public function create()
    {
        return view('Coordinacion.Informatica.Tablero.crear');
    }

    public function store(Request $request)
    {
        Lav_tc_tablero::create([
            'nombre_tablero' => $request->input('nombre_tablero')
        ]);
        return redirect()->route('tab_vista.index')->with('mensaje','El tablero '.$request->input('nombre_tablero').' creado con éxito!.');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $tablero = Lav_tc_tablero::find($id);
        return view('Coordinacion.Informatica.Tablero.editar', compact('tablero'));
    }

    public function update(Request $request, $id)
    {
        $tablero = Lav_tc_tablero::find($id);
        $tablero->update([
            'nombre_tablero' => $request->input('nombre_tablero')
        ]);
        return redirect()->route('tab_vista.index')->with('mensaje','El tablero '.$request->input('nombre_tablero').' editado con éxito!.');
    }

    public function destroy($id)
    {         
        $tablero = Lav_tc_tablero::find($id);
        try {
            $tablero->delete();
        } catch (\Throwable $th) {
            return redirect()->route('tab_vista.index')->with('error','¡El tablero posee vistas asociadas!'); 
        }
        
        return redirect()->route('tab_vista.index')->with('mensaje','El tablero se borro con éxito!.'); 
    }
    
    public function ruta($vista){
        $data = DB::SELECT('SELECT * FROM '.$vista);
        return $data;
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
