<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\barrio_terreno;    
    use App\Models\Iprodha\BarrioXOrg;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;    
    class BarrioXOrgController extends Controller{               
        public function index($unBarrio){            
            $Barrio=Barrio::where('barrio',$unBarrio)->get();
            $terrenos=barrio_terreno::where('barrio',$unBarrio)->get();
            $BarrioXOrg=BarrioXOrg::where('barrio',$unBarrio)->get();
            return view('barrio.dormXTerr',compact('Barrio','terrenos','BarrioXOrg'));
        }        
        public function edit($barrio){$unBarrio=Barrio::find($barrio);} 
        public function store(Request $request){
            $unBarrioXOrg=new BarrioXOrg;
            $unBarrioXOrg->barrio=$request->input('barrio');
            $unBarrioXOrg->candor=$request->input('candor');
            $unBarrioXOrg->idtipoterre=$request->input('idtipoterre');
            $unBarrioXOrg->save();
            return redirect()->route('barrio.dormXTerr',$unBarrio->barrio)->with('mensaje','creado con exito.');
        }
        public function destroy($barrio,$dor,$terr){            
            $barrioXOrg=BarrioXOrg::where('barrio',$barrio)->where('idtipoterre',$terr)->where('candor',$dor);            
            $barrioXOrg->delete();
            return redirect()->route('barrio.dormXTerr',$barrio)->with('mensaje','borrado con éxito!.');
        }       
    }