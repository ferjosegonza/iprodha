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
            ->orderBy('cantdorm')
            ->orderBy('Fc_concosxbarrio.idtipoterre')
            ->orderBy('id_concosto')
            ->get();
            return view('barrio.dormXTerr',compact('Barrio','terrenos','Fc_concosxbarrio'));
        }                
        public function store(Request $request){                                                              
            $dor=[];
            $sumaoresta=($request->input('id_concosto')==6)?-1:1;
            $concosto=array(1=>'VIVIENDA',2=>'TERRENO',3=>'INFRAESTRUCTURA',4=>'NEXO',6=>'SUBSIDIO');

            if($request->input('idtipoterre')=='Todos'){$barrio_terreno=barrio_terreno::where('barrio',$request->input('barrio'))->get();}
            else{$barrio_terreno=barrio_terreno::where('barrio',$request->input('barrio'))->where('idtipoterre',$request->input('idtipoterre'))->get();}            
            if($request->input('candor')=='Todos'){
                $Barrio=Barrio::select('mts1','mts2','mts3','mts4')->where('barrio',$request->input('barrio'))->get();                  
                foreach($Barrio as $Barrio){}
                if($Barrio->mts1>0){$dor[0]=1;}
                if($Barrio->mts2>0){$dor[1]=2;}
                if($Barrio->mts3>0){$dor[2]=3;}
                if($Barrio->mts4>0){$dor[3]=4;}
            }else{$dor[0]=$request->input('candor');}
            
            foreach($barrio_terreno as $unBarrio_terreno){                
                foreach($dor as $unDor){   
                    //busco el registro                                     
                    $barrioXOrg=BarrioXOrg::where('barrio',$request->input('barrio'))
                    ->where('idtipoterre',$unBarrio_terreno->idtipoterre)
                    ->where('candor',$unDor);                    
                    if($barrioXOrg->count()==0){//si no existe el registro lo inserto
                        $unBarrioXOrg=new BarrioXOrg;
                        $unBarrioXOrg->barrio=$request->input('barrio');
                        $unBarrioXOrg->candor=$unDor;
                        $unBarrioXOrg->idtipoterre=$unBarrio_terreno->idtipoterre;
                        $unBarrioXOrg->idorganismo=0;
                        $unBarrioXOrg->plazo=360;
                        $unBarrioXOrg->idtipofac=0;
                        $unBarrioXOrg->save();
                    }
                    //busco el registro
                    $Fc_concosxbarrio=Fc_concosxbarrio::where('barrio',$request->input('barrio'))
                    ->where('idtipoterre',$unBarrio_terreno->idtipoterre)
                    ->where('cantdorm',$unDor)
                    ->where('id_concosto',$request->input('id_concosto'));
                    if($Fc_concosxbarrio->count()==0){//si no existe el registro lo inserto
                        $unFc_concosxbarrio=new Fc_concosxbarrio;
                        $unFc_concosxbarrio->barrio=$request->input('barrio');
                        $unFc_concosxbarrio->idorganismo=0;
                        $unFc_concosxbarrio->id_concosto=$request->input('id_concosto');
                        $unFc_concosxbarrio->concosto=$concosto[$request->input('id_concosto')];
                        $unFc_concosxbarrio->sumaoresta=$sumaoresta;
                        $unFc_concosxbarrio->importe=$request->input('importe');
                        $unFc_concosxbarrio->cantdorm=$unDor;
                        $unFc_concosxbarrio->idtipofac=0;
                        $unFc_concosxbarrio->idtipoterre=$unBarrio_terreno->idtipoterre;
                        $unFc_concosxbarrio->save();
                    }
                }
            }                        
            return redirect()->route('barrio.dormXTerr',$request->input('barrio'))->with('mensaje','creado con exito.');
        }        
        public function destroy($bar,$dor,$ter,$con){            
            $Fc_concosxbarrio=Fc_concosxbarrio::where('barrio',$bar)->where('idtipoterre',$ter)->where('cantdorm',$dor)->where('id_concosto',$con);
            $Fc_concosxbarrio->delete();
            $Fc_concosxbarrio=Fc_concosxbarrio::where('barrio',$bar)->where('idtipoterre',$ter)->where('cantdorm',$dor);
            if($Fc_concosxbarrio->count()==0){//si no existe el registro lo borro en la otra tabla
                $barrioXOrg=BarrioXOrg::where('barrio',$bar)->where('idtipoterre',$ter)->where('candor',$dor);            
                $barrioXOrg->delete();            
            }
            return redirect()->route('barrio.dormXTerr',$bar)->with('mensaje','borrado con éxito!.');
        }       
    }