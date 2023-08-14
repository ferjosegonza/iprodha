<?php

namespace App\Http\Controllers\Coordinacion\Notarial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Iprodha\Not_tramite;
use App\Models\Iprodha\Not_tramite_tipo;
use App\Models\Iprodha\Not_profesional;
use App\Models\Iprodha\Not_profesional_caracter;
use App\Models\Iprodha\Not_funcionario_tipo;
use App\Models\Usua400\Fescrib;
use DB;

class NotarialController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function bandeja(){      
        $tramites = Not_tramite::join('iprodha.not_tramite_tipo', 'iprodha.not_tramite_tipo.id_tipo', 'iprodha.not_tramite.id_tipo')->where('estado', '=', '1')->get();
        return view('Coordinacion.Notarial.bandeja')
        ->with('tramites',$tramites);       
    }

    public function alta_tramite(){      
        $tipos = Not_tramite_tipo::get();
        $profesional = Not_profesional::get();
        $caracter = Not_profesional_caracter::get();
        $funcionario = Not_funcionario_tipo::get();
        return view('Coordinacion.Notarial.alta_tramite')
        ->with('tipos', $tipos)
        ->with('profesional', $profesional)
        ->with('caracter', $caracter)
        ->with('funcionario', $funcionario);       
    }
    
    public function buscarEscribano(Request $request){
        $escribanos = Fescrib::select('nombre', 'telef1', 'cuit', 'matricula', 'email')->where('nombre', 'like', '%'.strtoupper($request->nom).'%')->get();
        return response()->json($escribanos);
    }

    public function buscarBeneficiario(Request $request){
        $query = "select ope, barrio, adju, nrdoca, apyna
        from  iprodha.VW_AHCRPI_JUNTOS 
        where (ope = 'CR' or ope= 'PI')
        and nrdoca = $request->dni";
        $beneficiarios = DB::select( DB::raw($query));
        return response()->json($beneficiarios);
    }

    public function buscarDocumento(Request $request){
        if($request->tipo == 'nota'){
            $query = "SELECT NOT_DOC_ID, NOT_NUMERO, not_asunto FROM ME.NOTAS 
            WHERE not_numero like '%$request->nro%'";
        }
        else{
            $query = "SELECT EXP_DOC_ID, EXP_NUMERO, exp_asunto FROM ME.EXPEDIENTES
            WHERE exp_numero like '%$request->nro%'";
        }        
        $documentos = DB::select( DB::raw($query));
        return response()->json($documentos);
    }
}