<?php
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\ob_licitacion;
    use App\Models\Iprodha\ob_tipo_licitacion;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;

    class ob_licitacionController extends Controller{
        public function index(){            
            $ob_licitacion=ob_licitacion::with('ob_tipo_licitacion')
            ->join('iprodha.ob_tipo_licitacion',function($join){
                $join->on('ob_licitacion.id_tipo','=','ob_tipo_licitacion.id_tipolic');
            })
            ->orderBy('año','asc')
            ->get();
            return view('ob_licitacion/index',compact('ob_licitacion'));            
        }   
        public function create(){
            $ob_tipo_licitacion=ob_tipo_licitacion::pluck('descripcion','id_tipolic');               
            return view('ob_licitacion.crear',compact('ob_tipo_licitacion'));
        }  
        public function store(Request $request){
            $unOb_licitacion=new ob_licitacion;  
            $unOb_licitacion->id_licitacion=ob_licitacion::max('id_licitacion')+1;          
            $unOb_licitacion->numero=$request->input('numero');
            $unOb_licitacion->denominacion=$request->input('denominacion');
            $unOb_licitacion->año=$request->input('año');
            $unOb_licitacion->apertura=$request->input('apertura');
            $unOb_licitacion->id_tipo=$request->input('id_tipolic');
            $unOb_licitacion->path=$request->input('path');
            $unOb_licitacion->save();
            return redirect()->route('ob_lic.index')->with('mensaje','Licitacion '.$unOb_licitacion->denominacion.' creada con exito.');
        }   
        public function subir(Request $request){return view('ob_licitacion.subir',compact('request'));}
        public function subir1(Request $request){
            // Validación del archivo (tamaño, tipo, etc.) aquí si es necesario            
            $archivo=$request->file('archivo');            
            // Guardar el archivo en el sistema de archivos
            $archivo->storeAs($request['dir'],$archivo->getClientOriginalName());
            // Lógica adicional (guardar la ruta en la base de datos, etc.) aquí si es necesario
            return redirect()->route('ob_lic.index')->with('mensaje','Archivo subido con éxito');
        }
    }