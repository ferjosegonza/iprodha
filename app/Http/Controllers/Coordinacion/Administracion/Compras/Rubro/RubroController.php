<?php

namespace App\Http\Controllers\Coordinacion\Administracion\Compras\Rubro;

use App\Http\Controllers\Controller;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Pat_rubro_emp;
use App\Models\Iprodha\Pat_rubroxemp;
use App\Models\Iprodha\Vw_pat_paracargarubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-RUBROS|CREAR-RUBROS|EDITAR-RUBROS|BORRAR-RUBROS', ['only' => ['index']]);
        $this->middleware('permission:CREAR-RUBROS', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-RUBROS', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-RUBROS', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
        $name = $request->query->get('name');
        // return $name;
        if (!isset($name)) {
               
            //Con paginación
            $rubros = Pat_rubro_emp::orderBy('rubro', 'asc')->get();
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $rubros = Pat_rubro_emp::whereRaw('UPPER(rubro) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('rubro', 'asc')->get();
        }
        
        // return view ('Coordinacion.Informatica.ticket.categoriaproblema.index', compact('CatProbs'));
        return view('Coordinacion.Administracion.Compras.Rubro.index', compact('rubros'));
    }

    
    public function create()
    {
        return view('Coordinacion.Administracion.Compras.Rubro.crear');
    }

    
    public function store(Request $request)
    {
        $this->validate($request, [
            'rubro' => 'required|string',
        ]);

        // $input = $request->all();

        $existeRubro = Pat_rubro_emp::where('rubro','=', strtoupper($request->input('rubro')))->first();
        $nombreRubro = strtoupper($request->input('rubro'));

        if(empty($existeRubro)){
            $rubro = Pat_rubro_emp::create(['rubro' => $nombreRubro]);
            return redirect()->route('rubros.index')->with('mensaje','El rubro '.$rubro->rubro.' creado con exito.');
        }else{
            return redirect()->route('rubros.create')->with('alerta','¡El rubro ya existe!');
        }

       
    //    $nuevoCrono = Ofe_cronograma::create(['iditem' => $item, 'mes' => $mes, 'avance' => $avance]);
 
    }

    
    public function show(Request $request, $id)
    {
        
        if(empty($request->input())){
            $rubros = Pat_rubroxemp::where('id_emp', '=', $id)->get();
            
            foreach($rubros as $rubro){
                $rubro->delete();
            }

        }else{
            $rubros = $request->input('rubros');
            $total = count($rubros);
            
            $rubrosAsignados = Pat_rubroxemp::select('iprodha.pat_rubroxemp.id as idrxe', 'iprodha.pat_rubroxemp.id_emp', 'iprodha.pat_rubro_emp.id', 'iprodha.pat_rubro_emp.rubro' )
                ->join('iprodha.pat_rubro_emp', 'iprodha.pat_rubroxemp.id_rubro', '=', 'iprodha.pat_rubro_emp.id')
                ->where('iprodha.pat_rubroxemp.id_emp', '=' , $id)
                ->get();

            if($rubrosAsignados->isEmpty()){
                
                for ($i=0; $i < $total; $i++) { 
                    Pat_rubroxemp::create(['id_emp' => $id, 'id_rubro' => $rubros[$i]]);
                }

            }else{
    
                foreach ($rubrosAsignados as $rubroAsignado) { 
                    if(!in_array($rubroAsignado->id, $rubros)){
                        $rubroBorrado = Pat_rubroxemp::where("id",$rubroAsignado->idrxe)->first();
                        $rubroBorrado->delete();
                    }
                }

                for ($i=0; $i < $total; $i++) { 
                  $existeRubro = $rubrosAsignados->where('id', $rubros[$i]);
                  if($existeRubro->isEmpty()){
                    Pat_rubroxemp::create(['id_emp' => $id, 'id_rubro' => $rubros[$i]]);
                  } 
                }
            }
            
        }
        return redirect()->route('rubroxemp.asignar', encrypt($id))->with('mensaje','Se modifico los rubros con exito.');
    }

    
    public function edit(Request $request, Pat_rubro_emp $rubro)
    {
        return view('Coordinacion.Administracion.Compras.Rubro.editar', compact('rubro'));
    }

    
    public function update(Request $request, Pat_rubro_emp $rubro)
    {
        $rubro->update(['rubro' => strtoupper($request->input('rubro'))]);
        return redirect()->route('rubros.index')->with('mensaje','El rubro se modifico con exito.');       
    }

    
    public function destroy(Pat_rubro_emp $rubro)
    {
        $rubroUso = Pat_rubroxemp::where('id_rubro', $rubro->id)->get();
        if($rubroUso->isEmpty()){
            $rubro->delete();
            return redirect()->route('rubros.index')->with('mensaje','El rubro se borro con exito.');
        }else{
            return redirect()->route('rubros.index')->with('alerta','El rubro se encuentra asignado a una empresa.');
        }
        
    }

    public function empresaxrubro(Request $request)
    {
        $name = $request->query->get('name');

        if (!isset($name)) {
            //Con paginación
            $empresas = Vw_pat_paracargarubro::orderBy('nom_emp','asc')->paginate(300);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $empresas = Vw_pat_paracargarubro::where('cuit', 'like', '%'.$name.'%')->orWhere('nom_emp', 'like', '%' . strtoupper($name) . '%')->orderBy('nom_emp','asc')->paginate(300);
        }
        return view('Coordinacion.Administracion.Compras.Rubro.Empxrubro.index', compact('empresas'));
    }

    public function asignarRubro(Request $request, $id)
    {
        $empresa = Empresa::find(decrypt($id));
        $rubros = Pat_rubro_emp::orderBy('rubro', 'asc')->get();
        $listaRubros = array();
        
        $rubrosAsignados = Pat_rubroxemp::select('iprodha.pat_rubroxemp.id_emp', 'iprodha.pat_rubro_emp.id', 'iprodha.pat_rubro_emp.rubro' )
                ->join('iprodha.pat_rubro_emp', 'iprodha.pat_rubroxemp.id_rubro', '=', 'iprodha.pat_rubro_emp.id')
                ->where('iprodha.pat_rubroxemp.id_emp', '=' , decrypt($id))
                ->get();
              
        foreach ($rubrosAsignados as $rubroAsignado) { 
           array_push($listaRubros, $rubroAsignado->id);
        }

        return view('Coordinacion.Administracion.Compras.Rubro.Empxrubro.asignar', compact('empresa', 'rubros', 'rubrosAsignados', 'listaRubros'));
    }

    public function buscarRubroNombre($nombre){
        $nombre = strtoupper($nombre);
        $rubros = Pat_rubro_emp::where('rubro', 'like', '%'.$nombre.'%')->get();

        if($rubros->isEmpty()){
            return response(['message' => 'No se encuentra.']);
        }else{
            return $rubros;
        }
    }

    public function todosLosRubros(){
        return $rubros = Pat_rubro_emp::orderBy('rubro', 'asc')->get();
    }
}