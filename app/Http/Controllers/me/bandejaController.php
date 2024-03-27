<?php
    namespace App\Http\Controllers\me;
    use App\Http\Controllers\Controller;
    use App\Models\Diegoz\users_x_areas;    
    use App\Models\Me\vw_bandeja_entrada;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Session;
    class bandejaController extends Controller{        
        public function index(){
            $sesionArray=Session::all();// Obtener todo el array de sesiones
            $valores=array_values($sesionArray); // Obtener todos los valores del array de sesiones            
            $areas=users_x_areas::where('id',$valores[4])->get(); 
            $ids=$areas->pluck('codare');            
            $exptes=vw_bandeja_entrada::where('tipo','EXPEDIENTE')->whereIn('MOV_DEP_ID',$ids)->get();
            $notas=vw_bandeja_entrada::where('tipo','NOTA')->whereIn('MOV_DEP_ID',$ids)->get();
            $correspondencias=vw_bandeja_entrada::where('tipo','CORRESPONDENCIA')->whereIn('MOV_DEP_ID',$ids)->get();
            $convenios=vw_bandeja_entrada::where('tipo','CONVENIO')->whereIn('MOV_DEP_ID',$ids)->get();
            return view('me.bandeja',compact('exptes','notas','correspondencias','convenios'));
        }
    }