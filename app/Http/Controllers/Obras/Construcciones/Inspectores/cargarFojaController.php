<?php
    namespace App\Http\Controllers\Obras\Construcciones\Inspectores;
    use App\Models\Iprodha\cargarFoja;
    use App\Models\Iprodha\ob_det_foja;
    use App\Models\Iprodha\ob_obrasxweb;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class cargarFojaController extends Controller{        
        function __construct(){
            $this->middleware('auth');
            $this->middleware('permission:VER-CARGARFOJA|CREAR-CARGARFOJA|EDITAR-CARGARFOJA|BORRAR-CARGARFOJA',['only'=>['index']]);
            //$this->middleware('permission:CREAR-CARGARFOJA', ['only' => ['create','store']]);
            $this->middleware('permission:EDITAR-CARGARFOJA',['only'=>['edit','update']]);
            //$this->middleware('permission:BORRAR-CARGARFOJA', ['only' => ['destroy']]);
            //$this->middleware('permission:VER-CARGARFOJA', ['only' => ['buscarpermisos','buscarpermisosdelrol','listarrolessinpremisos','listarrolesconpremisos','pdf']]);            
        }        
        public function index(){  
            $ob_obrasxweb=ob_obrasxweb::select('id_obr')->where('foja','1')->get();
            $id_obr='';
            for($i=0;$i<count($ob_obrasxweb);$i++){
                $id_obr.=$ob_obrasxweb[$i]->id_obr.',';
            }
            return$id_obr.='0';

            $cargarFoja=cargarFoja::select('id_obr','num_obr','nom_obr','nom_emp')            
            ->where('id_inspector','79')
            //->whereIn('id_obr',$ob_obrasxweb)
            ->groupBy('id_obr','num_obr','nom_obr','nom_emp')
            ->orderBy('num_obr')
            ->get();        
            return view('obras.Construcciones.Inspectores.cargarfoja.cargarFoja',compact('cargarFoja'));
        } 
        public function edit(Request $request,$id_obr){
            $cargarFoja=cargarFoja::where('id_obr',$id_obr)->orderBy('orden')->get();            
            return view('obras.Construcciones.Inspectores.cargarfoja.editar',compact('cargarFoja'));
        }
        public function update(Request $request,$id_foja){
            for($i=1;$i<=$request->input('orden');$i++){                  
                $ob_det_foja=ob_det_foja::where('id_foja',$id_foja)->where('id_item',$request->input('id_item'.$i))->first();
                $ob_det_foja->por_mes_obr=$request->input('por_mes_obr'.$i);                                         
                $ob_det_foja->por_acu_obr=$request->input('por_acu_obr'.$i);                
                $ob_det_foja->save();
            }            
            return redirect()->route('cargarfoja.index')->with('mensaje','Foja editada con éxito!.');            
        }
    }