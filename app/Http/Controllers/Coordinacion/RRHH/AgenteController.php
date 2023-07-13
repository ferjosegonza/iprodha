<?php

namespace App\Http\Controllers\Coordinacion\RRHH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Personal\Agente;
use App\Models\Personal\Historial;
use App\Models\Personal\Historial_Archivo;

class AgenteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function buscar(Request $request){
        $dni = $request->dni;
        $agente = Agente::where('nrodoc', '=', $dni)->first();
        return response()->json($agente);
    }

    public function historial(Request $request){
        $id = $request->id;
        $historial = Historial::where('idagente', '=', $id)->leftJoin('PERSONAL.HISTORIAL_ARCHIVO', 'PERSONAL.HISTORIAL_ARCHIVO.idhistorial','PERSONAL.HISTORIAL.idhistorial')->orderBy('fecha')->get();
        return response()->json($historial);
    }
}
