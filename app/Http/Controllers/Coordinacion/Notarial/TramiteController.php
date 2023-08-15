<?php

namespace App\Http\Controllers\Coordinacion\Notarial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iprodha\Not_tramite;
use App\Models\Iprodha\Not_tramite_documento;
use App\Models\Iprodha\Not_tramite_profesional;
use App\Models\Iprodha\Not_tramite_funcionario;
use App\Models\Iprodha\Not_tramite_beneficiario;
use App\Models\Iprodha\Not_tramite_escribano;
use App\Models\Iprodha\Not_tramite_movimiento;


class TramiteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function crear(Request $request){
        $res = 1;
        $tramites = json_decode($request->tramite);

        $this->validate($request, [
            'doc' => 'required|numeric|max:99999999|min:10000000',
            'nombre' => 'required',
            'cel' => 'numeric|nullable',
            'tipo' => 'required|numeric'
        ]);

        $tramite = new Not_tramite;
        $res *= $tramite->crearTramite($request->tipo, $request->cel, $request->email, $request->nombre, $request->doc);
        $id = $tramite->id_tramite;
        
        if($tramites->documento == 1){
            $doc = new Not_tramite_documento;
            $res *= $doc->crear($id, $tramites->documento_id);
        }
        if($tramites->profesional == 1){
            $prof = new Not_tramite_profesional;
            $res *= $prof->crear($id, $tramites->profesional_id, $tramites->profesional_car);
        }
        if($tramites->funcionario == 1){
            $func = new Not_tramite_funcionario;
            $res *= $func->crear($id, $tramites->funcionario_id, $tramites->funcionario_obs);
        }
        if($tramites->beneficiario == 1){
            $ben = new Not_tramite_beneficiario;
            $res *= $ben->crear($id, $tramites->beneficiario_dni, $tramites->beneficiario_ope, $tramites->beneficiario_bar, $tramites->beneficiario_adj);
        }
        if($tramites->escribano == 1){
            $esc = new Not_tramite_escribano;
            $res *= $esc->crear($id, $tramites->escribano_mat);
        }

        return response()->json($res);        
    }
    
    public function movimiento(Request $request){
        $mov = new Not_tramite_movimiento;
        $res = $mov->crear($request->id, $request->obs, $request->medio);
        return response()->json($res);
    }

    public function getMovimientos(Request $request){
        $movimientos = Not_tramite_movimiento::join('iprodha.not_tramite_medio', 'iprodha.not_tramite_medio.id_medio', 'iprodha.not_tramite_movimiento.id_medio')->where('id_tramite', '=', $request->id)->get();
        return response()->json($movimientos);
    }

    public function cerrar($id){
        $tramite = Not_tramite::where('id_tramite','=', $id)->first();
        $res = $tramite->update(['estado'=>'0']);
        return response()->json($tramite);
    }

    public function getTramites(){
        $tramites = Not_tramite::where('estado', '=', '1')->get();
        return response()->json($tramites);
    }
}