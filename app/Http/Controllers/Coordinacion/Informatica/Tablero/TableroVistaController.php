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



class TableroVistaController extends Controller
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
        $tableros = Lav_tc_tablero::orderBy('nombre_tablero')->pluck('nombre_tablero', 'id_tc_tablero');
        return view('Coordinacion.Informatica.Tablero.VistaRuta.crear', compact('tableros'));
    }

    public function store(Request $request)
    {
        $nombreTablero = Lav_tc_tablero::find($request->input('idtablero'));
        $nombreVista = 'iprodha.vw_tc_'.$nombreTablero->nombre_tablero.'_'.$request->input('alias');

        Lav_tc_vista::create([
            'alias_vista' => $request->input('alias'),
            'nombre_vista' => $nombreVista,
            'id_tc_tablero' => $request->input('idtablero')
        ]);

        try {
            $permisoVistaDB = 'GRANT SELECT ON '.$nombreVista.' TO DIEGOZ;';
            DB::statement($permisoUserDB);
            return redirect()->route('tab_vista.index')->with('mensaje','La vista '.$request->input('nombre').' creado con éxito!.');
        } catch (\Throwable $th) {
            return redirect()->route('tab_vista.index')->with('mensaje','La vista '.$request->input('nombre').' creado con éxito!.');
        }
        
                    // DB::select(DB::raw($permisoUserDB));
        //DB::statement($permisoUserDB);
        // return redirect()->route('tab_vista.index')->with('mensaje','La vista '.$request->input('nombre').' creado con éxito!.');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $tableros = Lav_tc_tablero::orderBy('nombre_tablero')->pluck('nombre_tablero', 'id_tc_tablero');
        $vista = Lav_tc_vista::find($id);
        return view('Coordinacion.Informatica.Tablero.VistaRuta.editar', compact('tableros', 'vista'));
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
        $vista = Lav_tc_vista::find($id);
        $vista->delete();
        return redirect()->route('tab_vista.index')->with('mensaje','La vista se borro con éxito!.'); 
    }
    
    public function obtenerDatos($tablero, $alias){
        $tablero = Lav_tc_tablero::where('nombre_tablero', $tablero)->first();
        $vista = $tablero->getVistas->where('alias_vista', $alias)->first();
        $data = DB::SELECT('SELECT * FROM '.$vista->nombre_vista);
        // return $data;
        // $data = $alias;
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function generarCodigo($tablero, $alias){
        $tablero = Lav_tc_tablero::where('nombre_tablero', $tablero)->first();
        $vista = $tablero->getVistas->where('alias_vista', $alias)->first();
        $nombreVista = substr($vista->nombre_vista, 8);
        return $codigo = DB::select('SELECT iprodha.fun_app_script(?, ?, ?) as codigo from dual', [$tablero->nombre_tablero, $alias, $nombreVista]);
    }
}
