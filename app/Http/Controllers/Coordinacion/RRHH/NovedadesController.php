<?php

namespace App\Http\Controllers\Coordinacion\RRHH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Dig_tipoarchivo;
use App\Models\Personal\Agente;
use App\Models\Iprodha\Dig_subtipoarchivo;

class NovedadesController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function novedades(){        
        return view('rrhh.novedades');
    }

    public function crear_novedad(Request $request, $id){
        $agente = Agente::where('idagente', '=', $id)->first();
        $TipoDocumento = Dig_tipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('nombre_corto')->get();
        $SubTipoDocumento = Dig_subtipoarchivo::where('id_tipocabecera', '=', 1)->orderBy('dessubtipoarchivo')->orderBy('id_tipoarchivo', 'asc')->orderBy('id_subtipoarchivo', 'asc')->get();
        return view('rrhh.crear_novedad')
        ->with('tipos',$TipoDocumento)
        ->with('subtipos',$SubTipoDocumento)
        ->with('agente', $agente);
    }
}
