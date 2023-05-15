<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\barrio_terreno;    
    use App\Models\Iprodha\barrioXOrg;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;    
    class barrioXOrgController extends Controller{
        function __construct(){
            /*$this->middleware('auth');
            $this->middleware('permission:VER-BARRIOCOSTOS|CREAR-BARRIOCOSTOS|EDITAR-BARRIOCOSTOS|BORRAR-BARRIOCOSTOS', ['only' => ['index']]);
            $this->middleware('permission:CREAR-BARRIO', ['only' => ['create','store']]);
            $this->middleware('permission:EDITAR-BARRIO', ['only' => ['edit','update']]);
            $this->middleware('permission:BORRAR-BARRIO', ['only' => ['destroy']]);*/
        }        
        public function index($unBarrio){
            $Barrios=Barrio::where('barrio',$unBarrio)->get();
            $terrenos=barrio_terreno::where('barrio',$unBarrio)->get();
            return view('barrio.terrenoSup',compact('terrenos','unBarrio'));
        }        
        public function edit($barrio){            
            $unBarrio=Barrio::find($barrio);
            //$Costos=Fc_concosxbarrio::where('barrio','like',$unBarrio->barrio)->paginate(10);
            //$Dormis1=Fc_concosxbarrio::select('cantdorm')->distinct()->where('barrio','like',$unBarrio->barrio)->get();
            //$BarrioMen=Barrio_rg_plazo::select('plazo')->where('barrio_men','like',1)->get();
            //$BarrioAnual=Barrio_rg_plazo::select('plazo')->where('barrio_anual','like',1)->get();            
            //return view('barrio.verCostos',compact('unBarrio','Costos','Dormis1','BarrioMen','BarrioAnual'));
        }        
    }