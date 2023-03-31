<?php

namespace App\Http\Controllers\Coordinacion\Informatica\RegistroTrigger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//agregamos

use App\Models\Iprodha\Sistemas_trigger_det;
use App\Models\Iprodha\Sistemas_trigger_act;
use App\Models\Iprodha\Sistemas_trigger_tarea;


class TriggerController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
          $this->middleware('permission:VER-REGTRIGGER|CREAR-REGTRIGGER|EDITAR-REGTRIGGER|BORRAR-REGTRIGGER', ['only' => ['index']]);
          $this->middleware('permission:CREAR-REGTRIGGER', ['only' => ['create','store']]);
          $this->middleware('permission:EDITAR-REGTRIGGER', ['only' => ['edit','update']]);
          $this->middleware('permission:BORRAR-REGTRIGGER', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {    
        $name = $request->query->get('name');
    
        if (!isset($name)) {
               
            //Con paginación
            $regtriggers = Sistemas_trigger_act::orderBy('id', 'asc')->take(500)->get();
                                                            //  ->simplePaginate(10);
            //al usar esta paginacion, recordar poner en el el index.blade.php este codigo  {!! $roles->links() !!}
        } else {
            $regtriggers = Sistemas_trigger_act::whereRaw('UPPER(origen_tabla) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('id', 'asc')->take(500)->get();
        }
        
        return view ('Coordinacion.Informatica.RegistroTrigger.index', compact('regtriggers'));
    }
    
    public function create(Request $request)
    {
        $Tareas = Sistemas_trigger_tarea::all()->pluck('tarea', 'id')->prepend('Seleccionar', '0')->toArray();
        return view ('Coordinacion.Informatica.RegistroTrigger.crear', compact('Tareas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'esquema' => 'required|string',
            'tabla' => 'required|string',
            'logesquema' => 'required|string',
            'logtabla' => 'required|string',
            'tarea' => 'required|integer|between:1,999',
            'observ' => 'required|string',
        ], [
            'tarea.between' => 'Seleccione la tarea.',
        ]);

        $nuevoRegTrigger = Sistemas_trigger_act::create([
            'origen_esquema' => strtoupper($request->input('esquema')),
            'origen_tabla' => strtoupper($request->input('tabla')),
            'log_esquema' => strtoupper($request->input('logesquema')), 
            'log_tabla' => strtoupper($request->input('logtabla')),
        ]);
        
        $idTrigAct = Sistemas_trigger_act::where('log_tabla', '=', $nuevoRegTrigger->log_tabla)->first();

        Sistemas_trigger_det::create([
            'id_trigger_act' => $idTrigAct->id,
            'usuario' => Auth::user()->id,
            'observacion' => strtoupper($request->input('observ')),
            'idtarea' => $request->input('tarea'),
        ]);

        return redirect()->route('regtrigger.index')->with('mensaje','Se creo el registro trigger con exito');                             
    }

    public function show(Sistemas_trigger_act $regtrigger)
    {
        $Tareas = Sistemas_trigger_tarea::all()->pluck('tarea', 'id')->toArray();
        return view('Coordinacion.Informatica.RegistroTrigger.ver', compact('regtrigger', 'Tareas'));
    }
   
    public function edit(Sistemas_trigger_act $regtrigger)
    {
        $Tareas = Sistemas_trigger_tarea::all()->pluck('tarea', 'id')->toArray();
        return view('Coordinacion.Informatica.RegistroTrigger.editar', compact('regtrigger', 'Tareas'));
    }
    
    public function update(Request $request, Sistemas_trigger_act $regtrigger)
    {
        $this->validate($request, [
            'esquema' => 'required|string',
            'tabla' => 'required|string',
            'logesquema' => 'required|string',
            'logtabla' => 'required|string',
            'tarea' => 'required|integer|between:1,999',
            'observ' => 'required|string',
        ]);

        $regtrigger->update([
            'origen_esquema' => strtoupper($request->input('esquema')),
            'origen_tabla' => strtoupper($request->input('tabla')),
            'log_esquema' => strtoupper($request->input('logesquema')),
            'log_tabla' => strtoupper($request->input('logtabla')),
        ]);

        $detalle = Sistemas_trigger_det::where('id_trigger_act', '=', $regtrigger->id)->first();
    
        $detalle->update([
            'observacion' => strtoupper($request->input('observ')),
            'idtarea' => $request->input('tarea'),
        ]);

        return redirect()->route('regtrigger.index')->with('mensaje','Se edito el registro trigger con exito');                                                                                                                          
    }

    public function destroy(Sistemas_trigger_act $regtrigger)
    {
        $detalle = Sistemas_trigger_det::where('id_trigger_act', '=', $regtrigger->id)->delete();
        $regtrigger->delete();
        return redirect()->route('regtrigger.index')->with('mensaje','Se borro el registro trigger con exito'); 
    }

}
