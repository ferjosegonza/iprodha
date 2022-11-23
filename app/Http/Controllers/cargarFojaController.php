<?php
    namespace App\Http\Controllers;
    use App\Models\Iprodha\cargarFoja;
    use App\Models\Iprodha\ob_det_foja;
    use Illuminate\Http\Request;

    class cargarFojaController extends Controller{
        function __construct(){}
        public function index(){            
            $cargarFoja=cargarFoja::select('id_obr','num_obr','nom_obr','nom_emp')
            ->where('id_inspector','79')
            ->groupBy('id_obr','num_obr','nom_obr','nom_emp')
            ->orderBy('num_obr')
            ->get();        
            return view('cargarFoja/cargarFoja',compact('cargarFoja'));
        } 
        public function edit(Request $request,$id_obr){
            $cargarFoja=cargarFoja::where('id_obr',$id_obr)->orderBy('orden')->get();            
            return view('cargarFoja.editar',compact('cargarFoja'));
        }
        public function update(Request $request,$id_foja){            
            /*$this->validate($request, [
            'nombre' => 'required|alpha',
            'cuil' => 'required|numeric|max:99999999999|min:10000000',
            'fechanac' => 'required|date'
            ]);*/                                                                   
            for($i=1;$i<=$request->input('orden');$i++){                  
                $ob_det_foja=ob_det_foja::where('id_foja',$id_foja)->where('id_item',$request->input('id_item'.$i))->first();
                $ob_det_foja->por_mes_obr=$request->input('por_mes_obr'.$i);                                         
                $ob_det_foja->por_acu_obr=$request->input('por_acu_obr'.$i);
                $ob_det_foja->save();
            }            
            return redirect()->route('cargarFoja.index')->with('mensaje','Foja editada con éxito!.');            
        }
    }