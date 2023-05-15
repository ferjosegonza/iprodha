<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\barrio_terreno;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;
    class barrio_terrenoController extends Controller{
        public function index($unBarrio){
            $terrenos=barrio_terreno::where('barrio',$unBarrio)->get();
            return view('barrio.terrenoSup',compact('terrenos','unBarrio'));
        }
        public function destroy($barrio,$id){            
            $terreno=barrio_terreno::where('barrio',$barrio)->where('idtipoterre',$id);            
            $terreno->delete();
            return redirect()->route('barrio.terrenoSup',$barrio)->with('mensaje','Terreno borrado con éxito!.');
        }
        public function store(Request $request){                        
            $unbarrio=new barrio_terreno;
            $unbarrio->idtipoterre=barrio_terreno::where('barrio',$request->input('barrio'))->max('idtipoterre')+1;
            $unbarrio->barrio=$request->input('barrio');
            $unbarrio->superficie=$request->input('superficie');            
            $unbarrio->save();            
            return redirect()->route('barrio.terrenoSup',$request->input('barrio'))->with('mensaje','El Terreno creado con exito.');            
        }
    }