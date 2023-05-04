<?php
    namespace App\Http\Controllers\Barrio;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\Barrio;
    use App\Models\Iprodha\Obras;
    use App\Models\Iprodha\Localidad;
    use App\Models\Iprodha\Barrio_vw_tipoxtipologia;
    use App\Models\Iprodha\Barrio_programa;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;
    class BarrioController extends Controller{
        function __construct(){
            $this->middleware('auth');
            $this->middleware('permission:VER-BARRIO|CREAR-BARRIO|EDITAR-BARRIO|BORRAR-BARRIO',['only'=>['index']]);
            $this->middleware('permission:CREAR-BARRIO',['only'=>['create','store']]);
            $this->middleware('permission:EDITAR-BARRIO',['only'=>['edit','update']]);
            $this->middleware('permission:BORRAR-BARRIO',['only'=>['destroy']]);
        }        
        public function index(Request $request){
            $name=strtoupper($request->query->get('name'));
            if(!isset($name)){
                $Barrios=Barrio::orderBy('barrio','desc')->paginate(10);
                //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
            }else{
                //$roles = Role::where('name', 'like', '%' .$name . '%')->orderBy('updated_at', 'DESC')->paginate(10);
                $Barrios=Barrio::whereRaw('UPPER(nombarrio) LIKE ?',['%'.strtoupper($name).'%'])->orderBy('barrio','desc')->paginate(10);
            }            
            return view('barrio.index',compact('Barrios'));                
        }        
        public function create(Request $request){            
            $Localidad=Localidad::pluck('nom_loc','id_loc');
            $Obra=Obras::pluck('nom_obr','id_obr'); 
            $Programa=Barrio_programa::pluck('descripcion','id_programa');
            $Tipo=Barrio_vw_tipoxtipologia::pluck('tipologia','idtipologia'); 
            $Tipologia=Barrio_vw_tipoxtipologia::pluck('tipobarrio','idtipbarrio');
            return view('barrio.crear',compact('Localidad','Obra','Programa','Tipo','Tipologia'));
        }
        public function store(Request $request){                        
            $this->validate($request,['nombarrio'=>'required|min:5|max:250|string']);            
            $unbarrio=new Barrio;
            $unbarrio->barrio=Barrio::max('barrio')+1;            
            $unbarrio->nombarrio=$request->input('nombarrio');
            $unbarrio->id_obr=$request->input('id_obr');
            $unbarrio->id_loc=$request->input('id_loc');
            $unbarrio->tipofinan=($request->input('tipofinan')=='Si')?1:0;
            $unbarrio->factura=($request->input('factura')=='Si')?1:0;
            $unbarrio->fec_entrega=$request->input('fec_entrega');
            $unbarrio->idzona=$request->input('idzona');
            $unbarrio->id_programa=$request->input('id_programa');
            $unbarrio->IDTIPBARRIO=$request->input('idtipBarrio');
            $unbarrio->IDTIPOLOGIA=$request->input('idtipologia');
            $unbarrio->tipoprecio=$request->input('tipoPrecio');
            $unbarrio->cuentabco=$request->input('cuentabco');
            $unbarrio->porfin=$request->input('porfin');
            $unbarrio->canviv=$request->input('canviv');
            $unbarrio->nro_res=$request->input('nro_res');                                    
            $unbarrio->save();
            return redirect()->route('barrio.index')->with('mensaje','El barrio '.$unbarrio->nom_obr.' creado con exito.');
        }        
        public function edit($barrio){
            $unbarrio=Barrio::find($barrio);            
            $Localidad=Localidad::pluck('nom_loc','id_loc'); 
            $Obra=Obras::pluck('nom_obr','id_obr'); 
            $Tipo=Barrio_vw_tipoxtipologia::pluck('tipologia','idtipologia'); 
            $Tipologia=Barrio_vw_tipoxtipologia::pluck('tipobarrio','idtipbarrio'); 
            $Programa=Barrio_programa::pluck('descripcion','id_programa');             
            return view('barrio.editar',compact('unbarrio','Localidad','Obra','Tipo','Tipologia','Programa'));
        }        
        public function update(Request $request,$barrio){
            $this->validate($request,['nombarrio'=>'required|min:5|max:250|string']);                        
            $unbarrio=Barrio::find($barrio);
            $unbarrio->nombarrio=$request->input('nombarrio');
            $unbarrio->id_obr=$request->input('id_obrBarrio');
            $unbarrio->id_loc=$request->input('id_locBarrio');
            $unbarrio->tipofinan=($request->input('uvi')=='Si')?1:0;
            $unbarrio->factura=($request->input('factura1')=='Si')?1:0;
            $unbarrio->fec_entrega=$request->input('fec_entrega');
            $unbarrio->idzona=$request->input('idzona');
            $unbarrio->id_programa=$request->input('Programa');
            $unbarrio->IDTIPBARRIO=$request->input('tipoBarrio');
            $unbarrio->IDTIPOLOGIA=$request->input('tipologiaBarrio');
            $unbarrio->tipoprecio=$request->input('tipoPrecioBarrio');
            $unbarrio->cuentabco=$request->input('cuentabco');
            $unbarrio->porfin=$request->input('porfin');
            $unbarrio->canviv=$request->input('canviv');
            $unbarrio->nro_res=$request->input('nro_res');            
            $unbarrio->mts1=$request->input('mts1');
            $unbarrio->mts2=$request->input('mts2');
            $unbarrio->mts3=$request->input('mts3');
            $unbarrio->mts4=$request->input('mts4');
            $unbarrio->save();
            return redirect()->route('barrio.index')->with('mensaje','Barrio '.$request->input('nombarrio').' editado con éxito!.');
        }
        public function destroy($barrio){        
            $unbarrio=Barrio::find($barrio);            
            $unbarrio->delete();
            return redirect()->route('barrio.index')->with('mensaje','Barrio '. $unbarrio->nombarrio.' borrado con éxito!.');
        }
    }