<?php

namespace App\Http\Controllers\Coordinacion\Notarial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Iprodha\Not_tramite;
use App\Models\Iprodha\Not_tramite_tipo;
use App\Models\Iprodha\Not_tramite_movimiento;
use App\Models\Iprodha\Not_tramite_medio;
use App\Models\Iprodha\Not_tramite_profesional;
use App\Models\Iprodha\Not_tramite_funcionario;
use App\Models\Iprodha\Not_tramite_beneficiario;
use App\Models\Iprodha\Not_tramite_escribano;
use App\Models\Iprodha\Not_tramite_documento;
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
        $tramites = Not_tramite::select('iprodha.not_tramite.id_tramite', 'fecha', 'iprodha.not_tramite.id_tipo', 'celular_contacto', 'mail_contacto', 'estado', 'nombre_comitente', 'dni_comitente', 'descripcion', 'id_documento', 'tipo', 'numero')
        ->join('iprodha.not_tramite_tipo t', 't.id_tipo', 'iprodha.not_tramite.id_tipo')
        ->leftJoin('iprodha.not_tramite_documento d', 'd.id_tramite', 'iprodha.not_tramite.id_tramite')
        ->leftJoin('me.vw_documentos v', 'v.doc_id', 'd.id_documento')
        ->get();
        return view('Coordinacion.Notarial.bandeja')
        ->with('tramites',$tramites);       
    }

    public function alta_tramite(){      
        $tipos = Not_tramite_tipo::orderBy('descripcion')->get();
        $profesional = Not_profesional::orderBy('descripcion')->get();
        $caracter = Not_profesional_caracter::orderBy('descripcion')->get();
        $funcionario = Not_funcionario_tipo::orderBy('descripcion')->get();
        $escribanos = Fescrib::select('nombre', 'telef1', 'cuit', 'matricula', 'email')->where('activo', '=', '1')->orderBy('nombre')->get();
        return view('Coordinacion.Notarial.alta_tramite')
        ->with('tipos', $tipos)
        ->with('profesional', $profesional)
        ->with('caracter', $caracter)
        ->with('escribanos', $escribanos)
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

    public function movimientos($id){    
        $tramite = Not_tramite::where('id_tramite', '=',$id)->join('iprodha.not_tramite_tipo', 'iprodha.not_tramite_tipo.id_tipo', 'iprodha.not_tramite.id_tipo')->orderBy('fecha')->first();
        $movimientos = Not_tramite_movimiento::join('iprodha.not_tramite_medio', 'iprodha.not_tramite_medio.id_medio', 'iprodha.not_tramite_movimiento.id_medio')->where('id_tramite', '=', $id)->orderBy('fecha')->get();
        $medios = Not_tramite_medio::orderBy('descripcion')->get();
        $tipos = Not_tramite_tipo::orderBy('descripcion')->get();
        $profesional = Not_profesional::orderBy('descripcion')->get();
        $caracter = Not_profesional_caracter::orderBy('descripcion')->get();
        $funcionario = Not_funcionario_tipo::orderBy('descripcion')->get();
        $escribanos = Fescrib::select('nombre', 'telef1', 'cuit', 'matricula', 'email')->where('activo', '=', '1')->orderBy('nombre')->get();

        $asuntos = array('profesional' => 0, 'funcionario' => 0, 'escribano' => 0, 'beneficiario' => 0, 'documento' => 0);
        if(sizeof(Not_tramite_profesional::where('id_tramite', '=', $tramite->id_tramite)->get()) > 0){
            $asuntos['profesional'] = 1;
        }
        if(sizeof(Not_tramite_escribano::where('id_tramite', '=', $tramite->id_tramite)->get()) > 0){
            $asuntos['escribano'] = 1;
        }
        if(sizeof(Not_tramite_beneficiario::where('id_tramite', '=', $tramite->id_tramite)->get()) > 0){
            $asuntos['beneficiario'] = 1;
        }
        if(sizeof(Not_tramite_funcionario::where('id_tramite', '=', $tramite->id_tramite)->get()) > 0){
            $asuntos['funcionario'] = 1;
        }
        if(sizeof(Not_tramite_documento::where('id_tramite', '=', $tramite->id_tramite)->get()) > 0){
            $asuntos['documento'] = 1;
        }
        
        return view('Coordinacion.Notarial.movimientos')
        ->with('tipos', $tipos)
        ->with('tramite', $tramite)
        ->with('movimientos', $movimientos)
        ->with('profesional', $profesional)
        ->with('caracter', $caracter)
        ->with('funcionario', $funcionario)
        ->with('medio', $medios)
        ->with('escribanos', $escribanos)
        ->with('asuntos', $asuntos);
    }
}