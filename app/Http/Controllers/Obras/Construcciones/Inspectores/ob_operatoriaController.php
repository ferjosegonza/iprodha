<?php

    namespace App\Http\Controllers\Obras\Construcciones\Inspectores;
    use App\Models\Iprodha\ob_operatoria;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class ob_operatoriaController extends Controller{
        function __construct(){}
        public function index(){
            $ob_operatorias=ob_operatoria::find(1)->orderBy('operatoria')->get();      
            return view('obras.Construcciones.Inspectores.ob_operatoria.ob_operatoria',compact('ob_operatorias'));
        }        
        public function destroy($idOpertoria){
            $unaOperatoria=ob_operatoria::find($idOpertoria);
            $unaOperatoria->delete();            
            return redirect()->route('ob_operatoria.index')->with('mensaje','Operatoria '.$unaOperatoria->operatoria.' borrado con éxito!.');
        }
        public function edit(Request $request,$idOperatoria){
            $ob_operatoria=ob_operatoria::find($idOperatoria);
            return view('obras.Construcciones.Inspectores.ob_operatoria.editar',compact('ob_operatoria'));
        }
        public function create(){return view('ob_operatoria.crear');}
        public function store(Request $request){
            /*$this->validate($request,[
                'dni' => 'required|numeric|max:99999999|min:10000000|unique:oracle.iprodha.alumno,dni',
                'nombre' => 'required|alpha',
                'cuil' => 'required|numeric|max:99999999999|min:10000000|unique:oracle.iprodha.alumno,cuil',
                'fechanac' => 'required|date'
            ]);*/
            $ob_operatoria=new ob_operatoria;
            $ob_operatoria->id_ope=ob_operatoria::find(1)->max('id_ope')+1;
            $ob_operatoria->operatoria=$request->input('operatoria');
            $ob_operatoria->banco=$request->input('banco');
            $ob_operatoria->caracter=$request->input('caracter');        
            $ob_operatoria->save();
            return redirect()->route('ob_operatoria.index')->with('mensaje','Operatoria '.$ob_operatoria->operatoria.' creado con éxito!.');        
        }
        public function update(Request $request,$id_ope){
            /*$this->validate($request, [
            'nombre' => 'required|alpha',
            'cuil' => 'required|numeric|max:99999999999|min:10000000',
            'fechanac' => 'required|date'
            ]);*/
            $ob_operatoria=ob_operatoria::find($id_ope);
            $ob_operatoria->operatoria=$request->input('operatoria');
            $ob_operatoria->banco=$request->input('banco');
            $ob_operatoria->caracter=$request->input('caracter');
            $ob_operatoria->save();
            return redirect()->route('ob_operatoria.index')->with('mensaje','Operatoria '.$ob_operatoria->operatoria.' editado con éxito!.');        
        }
    }