<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\barrio_terreno;    
    use App\Models\Iprodha\BarrioXOrg;
    use App\Models\Iprodha\Fc_concosxbarrio;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;    
    class BarrioXOrgController extends Controller{               
        public function index($unBarrio){            
            $Barrio=Barrio::select('barrio','nombarrio','mts1','mts2','mts3','mts4')->where('barrio',$unBarrio)->get();
            $terrenos=barrio_terreno::where('barrio',$unBarrio)->get();
            $Fc_concosxbarrio=Fc_concosxbarrio::with('barrio_terreno')
            ->join('iprodha.barrio_terreno',function($join){
                $join->on('Fc_concosxbarrio.barrio','=','barrio_terreno.barrio')
                    ->on('Fc_concosxbarrio.idtipoterre','=','barrio_terreno.idtipoterre');
            })
            ->where('Fc_concosxbarrio.barrio','=',$unBarrio)
            ->select('Fc_concosxbarrio.*','barrio_terreno.superficie')
            ->get();
            return view('barrio.dormXTerr',compact('Barrio','terrenos','Fc_concosxbarrio'));
        }                
        public function store(Request $request){  
            if($request->input('idtipoterre')=='Todos'){$barrio_terreno::where('barrio',$request->input('barrio'))->get();}
            else{$barrio_terreno::where('barrio',$request->input('barrio'))->where('idtipoterre',$request->input('idtipoterre'));}
            if($request->input('candor')=='Todos'){$Barrio=Barrio::select('mts1','mts2','mts3','mts4')->where('barrio',$request->input('barrio'))->get();}
            else{}
            $barrioXOrg=BarrioXOrg::where('barrio',$request->input('barrio'))->where('idtipoterre',$request->input('idtipoterre'))->where('candor',$request->input('candor'));
            if($barrioXOrg->count()==0){//si no existe el registro lo inserto
                $unBarrioXOrg=new BarrioXOrg;
                $unBarrioXOrg->barrio=$request->input('barrio');
                $unBarrioXOrg->candor=$request->input('candor');
                $unBarrioXOrg->idtipoterre=$request->input('idtipoterre');
                $unBarrioXOrg->idorganismo=0;
                $unBarrioXOrg->plazo=360;
                $unBarrioXOrg->idtipofac=0;
                $unBarrioXOrg->save();            
            }
            /*
            $sumaoresta=1;
            switch($request->input('id_concosto')){
                case 1:
                    $concosto='VIVIENDA';
                    break;
                case 2:
                    $concosto='TERRENO';
                    break;
                case 3:
                    $concosto='INFRAESTRUCTURA';
                    break;
                case 4:
                    $concosto='NEXO';
                    break;
                case 6:
                    $concosto='SUBSIDIO';
                    $sumaoresta=-1;
                    break;                    
            }
            if($request->input('id_concosto')==1){//vivienda
                $mts1=Barrio::select('mts1')->where('barrio',$request->input('barrio'))->where('mts1','>','0');
                $mts2=Barrio::select('mts2')->where('barrio',$request->input('barrio'))->where('mts2','>','0');
                $mts3=Barrio::select('mts3')->where('barrio',$request->input('barrio'))->where('mts3','>','0');
                $mts4=Barrio::select('mts4')->where('barrio',$request->input('barrio'))->where('mts4','>','0');
                $dormitorios=$mts1->union($mts2)->union($mts3)->union($mts4)->get();
                $cant=$dormitorios->count();
                if($cant==1){//si hay solo un tipo de vivienda, inserto para todos los terrenos
                    $terrenos=barrio_terreno::where('barrio',$request->input('barrio'))->get();
                    foreach($terrenos as$terreno){  
                        $this->insFc_con($request,$concosto,$sumaoresta,$request->input('candor'),$terreno->idtipoterre);                                                                  
                    }                    
                }else{$this->insFc_con($request,$concosto,$sumaoresta,$request->input('candor'),$request->input('idtipoterre'));}
            }else if($request->input('id_concosto')==2){//terreno
                $terrenos=barrio_terreno::where('barrio',$request->input('barrio'))->get();
                $cant=$terrenos->count();
                if($cant==1){//si hay solo un tipo de terreno, inserto para todas las viviendas
                    $mts1=Barrio::selectRaw("'1' AS hab")->where('barrio',$request->input('barrio'))->where('mts1','>','0');
                    $mts2=Barrio::selectRaw("'2' AS hab")->where('barrio',$request->input('barrio'))->where('mts2','>','0');
                    $mts3=Barrio::selectRaw("'3' AS hab")->where('barrio',$request->input('barrio'))->where('mts3','>','0');
                    $mts4=Barrio::selectRaw("'4' AS hab")->where('barrio',$request->input('barrio'))->where('mts4','>','0');
                    $dormitorios=$mts1->union($mts2)->union($mts3)->union($mts4)->get();
                    foreach($dormitorios as$dormitorio){
                        $this->insFc_con($request,$concosto,$sumaoresta,$dormitorio->hab,$request->input('idtipoterre'));                        
                    }                    
                }else{$this->insFc_con($request,$concosto,$sumaoresta,$request->input('candor'),$request->input('idtipoterre'));}
            }else{$this->insFc_con($request,$concosto,$sumaoresta,$request->input('candor'),$request->input('idtipoterre'));}
            return redirect()->route('barrio.dormXTerr',$request->input('barrio'))->with('mensaje','creado con exito.');            
        }
        private function insFc_con($request,$concosto,$sumaoresta,$candor,$idt){
            $unFc_concosxbarrio=new Fc_concosxbarrio;
            $unFc_concosxbarrio->barrio=$request->input('barrio');
            $unFc_concosxbarrio->idorganismo=0;
            $unFc_concosxbarrio->id_concosto=$request->input('id_concosto');
            $unFc_concosxbarrio->concosto=$concosto;
            $unFc_concosxbarrio->sumaoresta=$sumaoresta;
            $unFc_concosxbarrio->importe=$request->input('importe');
            $unFc_concosxbarrio->cantdorm=$candor;
            $unFc_concosxbarrio->idtipofac=0;
            $unFc_concosxbarrio->idtipoterre=$idt;
            $unFc_concosxbarrio->save();            */
        }
        public function destroy($bar,$dor,$ter,$con){            
            $barrioXOrg=BarrioXOrg::where('barrio',$bar)->where('idtipoterre',$ter)->where('candor',$dor);            
            $barrioXOrg->delete();
            $Fc_concosxbarrio=Fc_concosxbarrio::where('barrio',$bar)->where('idtipoterre',$ter)->where('cantdorm',$dor)->where('id_concosto',$con);
            $Fc_concosxbarrio->delete();
            return redirect()->route('barrio.dormXTerr',$bar)->with('mensaje','borrado con éxito!.');
        }       
    }