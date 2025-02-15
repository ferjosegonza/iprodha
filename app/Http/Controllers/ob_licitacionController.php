<?php
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\ob_licitacion;
    use App\Models\Iprodha\ob_tipo_licitacion;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\File;
    use Symfony\Component\Finder\Finder;

    class ob_licitacionController extends Controller{
        function __construct(){
            $this->middleware('auth');            
            $this->middleware('permission:VER-OB_LIC|CREAR-OB_LIC|EDITAR-OB_LIC',['only'=>['index']]);
            $this->middleware('permission:CREAR-OB_LIC',['only'=>['create','store']]);
            $this->middleware('permission:EDITAR-OB_LIC',['only'=>['subir','subir1']]);
        }  
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
        public function subir(Request $request){ 
            if(!Storage::disk('public_uploads')->exists($request['dir']))Storage::disk('public_uploads')->makeDirectory($request['dir'],0777);
            // Crear un objeto Finder
            $finder=new Finder();
            $path=public_path()."/storage/upload/".$request['dir'];
            $archivos=File::files($path);//los archivos que hay en el directorio raiz
            // Buscar directorios de forma recursiva
            $directorios=$finder->directories()->in($path);
            $i=0;
            foreach($directorios as$subDirectorios){  
                $subArchivos[$i]=File::files($subDirectorios->getRealPath());
                $subCarpetas[$i]=$subDirectorios->getRelativePathname();
                $i++;
            }                                    
            return view('ob_licitacion.subir',compact('request','archivos','subCarpetas','subArchivos'));
        }
        public function subir1(Request $request){            
            if(!$request->hasFile('archivo'))return redirect()->back()->with('mensaje','No se ha seleccionado ningn archivo.');
            $archivo=$request->file('archivo');  
            //comprueba si no existe el directorio lo crea          
            if(!Storage::exists($request['dir'].$request->input('SUB')))Storage::makeDirectory($request['dir'].$request->input('SUB'),0777);            
            // Guardar el archivo en el sistema de archivos
            $archivo->storeAs($request['dir'].$request->input('SUB'),$archivo->getClientOriginalName(),'public_uploads');
            return redirect()->route('ob_lic.index')->with('mensaje','Archivo subido con éxito');
        }
        public function destroy(Request $request){            
            Storage::disk('public_uploads')->delete($request['dir']);
            return redirect()->route('ob_lic.index')->with('mensaje','Archivo Eliminado con éxito');
        }
    }