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
use DB;

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

    public function getEscribano(Request $request){
        $escribano = Not_tramite_escribano::select('id_tramite', 'ue.matricula', 'nombre', 'telef1', 'cuit', 'email')
        ->join('USUA400.FESCRIB ue', 'iprodha.not_tramite_escribano.matricula', 'ue.matricula')->where('id_tramite', '=', $request->id)->first();
        return response()->json($escribano);
    }

    public function getFuncionario(Request $request){
        $funcionario = Not_tramite_funcionario::select('t.id_tipo','observacion', 'descripcion')
        ->join('iprodha.not_funcionario_tipo t', 't.id_tipo', 'iprodha.not_tramite_funcionario.id_funcionario_tipo')
        ->where('id_tramite', '=', $request->id)->first();
        return response()->json($funcionario);        
    }

    public function getBeneficiario(Request $request){
        $beneficiario = Not_tramite_beneficiario::select('dni', 'vaj.ope', 'vaj.barrio', 'vaj.adju', 'vaj.apyna')
        ->join('iprodha.VW_AHCRPI_JUNTOS vaj', 'vaj.nrdoca', 'iprodha.not_tramite_beneficiario.dni')
        ->where('id_tramite', '=', $request->id)->first();
        return response()->json($beneficiario);      
    } 

    public function getProfesional(Request $request){
        $profesional = Not_tramite_profesional::select('np.id_profesional', 'np.descripcion as prof', 'car.id_caracter', 'car.descripcion as car')
        ->join('IPRODHA.NOT_PROFESIONAL np', 'np.id_profesional', 'IPRODHA.NOT_TRAMITE_PROFESIONAL.id_profesional')
        ->join('IPRODHA.NOT_PROFESIONAL_CARACTER car', 'car.id_caracter', 'IPRODHA.NOT_TRAMITE_PROFESIONAL.id_caracter')
        ->where('id_tramite', '=', $request->id)->first();
        return response()->json($profesional);      
    }

    public function getDocumento(Request $request){
        $query = "SELECT * from  me.vw_documentos doc
        left join ME.EXPEDIENTES ex
        on ex.exp_doc_id = doc.doc_id
        left join ME.NOTAS nota
        on nota.not_doc_id = doc.doc_id
        inner join iprodha.not_tramite_documento tr
        on tr.id_documento = doc.doc_id
        where tr.id_tramite = $request->id";
        $resultado = DB::select( DB::raw($query));
        if($resultado[0]->tipo == 'NOTA'){
            $documento = array('id' => $resultado[0]->doc_id, 'nro' => $resultado[0]->numero, 'asun' => $resultado[0]->not_asunto);
        }
        else{
            $documento = array('id' => $resultado[0]->doc_id, 'nro' => $resultado[0]->numero, 'asun' => $resultado[0]->exp_asunto);
        }
        return response()->json($resultado);      
    }

    public function modificar(Request $request){
        $res = 1;
        $tramites = json_decode($request->tramite);

        $this->validate($request, [
            'doc' => 'required|numeric|max:99999999|min:10000000',
            'nombre' => 'required',
            'cel' => 'numeric|nullable',
            'tipo' => 'required|numeric'
        ]);

        $tramite = Not_tramite::where('id_tramite', '=', $request->id)->first();
        $res *= $tramite->modificarTramite($request->tipo, $request->cel, $request->email, $request->nombre, $request->doc);
        $id = $tramite->id_tramite;
        
        $check = Not_tramite_documento::where('id_tramite', '=', $id)->first();
        if($tramites->documento == 1){           
            if($check == null){
                $doc = new Not_tramite_documento;
                $res *= $doc->crear($id, $tramites->documento_id); 
            }
            else{
                if($check->id_documento != $tramites->documento_id){
                    $res *=$check->delete();
                    $doc = new Not_tramite_documento;
                    $res *= $doc->crear($id, $tramites->documento_id); 
                }
            }            
        }
        else{
            if($check != null){
                $res *=$check->delete();
            }
        }

        $check = Not_tramite_profesional::where('id_tramite', '=', $id)->first();
        if($tramites->profesional == 1){           
            if($check == null){
                $prof = new Not_tramite_profesional;
                $res *= $prof->crear($id, $tramites->profesional_id, $tramites->profesional_car);
            }
            else{
                if($check->id_profesional != $tramites->profesional_id || $check->id_caracter != $tramites->profesional_car){
                    $res *=$check->delete();
                    $prof = new Not_tramite_profesional;
                    $res *= $prof->crear($id, $tramites->profesional_id, $tramites->profesional_car);
                }
            }            
        }
        else{
            if($check != null){
                $res *=$check->delete();
            }
        }

        $check = Not_tramite_funcionario::where('id_tramite', '=', $id)->first();
        if($tramites->funcionario == 1){           
            if($check == null){
                $func = new Not_tramite_funcionario;
                $res *= $func->crear($id, $tramites->funcionario_id, $tramites->funcionario_obs);
            }
            else{
                if($check->id_funcionario_tipo != $tramites->funcionario_id || $check->observacion != $tramites->funcionario_obs){
                    $res *=$check->delete();
                    $func = new Not_tramite_funcionario;
                    $res *= $func->crear($id, $tramites->funcionario_id, $tramites->funcionario_obs);
                }
            }            
        }
        else{
            if($check != null){
                $res *=$check->delete();
            }
        }

        $check = Not_tramite_beneficiario::where('id_tramite', '=', $id)->first();
        if($tramites->beneficiario == 1){           
            if($check == null){
                $ben = new Not_tramite_beneficiario;
                $res *= $ben->crear($id, $tramites->beneficiario_dni, $tramites->beneficiario_ope, $tramites->beneficiario_bar, $tramites->beneficiario_adj);
            }
            else{
                if($check->dni != $tramites->beneficiario_dni){
                    $res *= $check->delete();
                    $ben = new Not_tramite_beneficiario;
                    $res *= $ben->crear($id, $tramites->beneficiario_dni, $tramites->beneficiario_ope, $tramites->beneficiario_bar, $tramites->beneficiario_adj);
                }
            }            
        }
        else{
            if($check != null){
                $res *=$check->delete();
            }
        }

        $check = Not_tramite_escribano::where('id_tramite', '=', $id)->first();
        if($tramites->escribano == 1){           
            if($check == null){
                $esc = new Not_tramite_escribano;
                $res *= $esc->crear($id, $tramites->escribano_mat);
            }
            else{
                if($check->matricula != $tramites->escribano_mat){
                    $res *= $check->delete();
                    $esc = new Not_tramite_escribano;
                    $res *= $esc->crear($id, $tramites->escribano_mat);
                }
            }            
        }
        else{
            if($check != null){
                $res *=$check->delete();
            }
        }

        return response()->json($res);        
    }

    public function updateMovimiento(Request $request){
        $mov = Not_tramite_movimiento::where('id_movimiento', '=', $request->idmov)
        ->where('id_tramite', '=', $request->id)->first();
        $res = $mov->modificar($request->obs, $request->medio);
        return response()->json($res);
    }
}