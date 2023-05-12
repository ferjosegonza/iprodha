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
            return view('barrio.terrenoSup',compact('terrenos'));
        }
        public function destroy($barrio,$id){            
            $terreno=barrio_terreno::where('barrio',$barrio)->where('idtipoterre',$id);            
            $terreno->delete();
            return redirect()->route('barrio.terrenoSup',$barrio)->with('mensaje','Terreno borrado con éxito!.');
        }
        public function store(){
            $unbarrio=new barrio_terreno;
            $unbarrio->barrio=barrio_terreno::max('idtipoterre')+1;            
            $unbarrio->nombarrio=$request->input('nombarrio');
            $unbarrio->id_obr=$request->input('id_obr');            
            $unbarrio->save();
            return redirect()->route('barrio.terrenoSup')->with('mensaje','El barrio creado con exito.');

        }
    }