<?php

namespace App\Http\Controllers\Presidencia;

use Illuminate\Http\Request;

//agregamos lo siguiente
use App\Http\Controllers\Controller;
use App\Models\Iprodha\EstadoObras;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class EstadoObrasController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-ESTADOOBRAS|CREAR-ESTADOOBRAS|EDITAR-ESTADOOBRAS|BORRAR-ESTADOOBRAS', ['only' => ['index','programas','empresas']]);
        $this->middleware('permission:CREAR-ESTADOOBRAS', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-ESTADOOBRAS', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-ESTADOOBRAS', ['only' => ['destroy']]);
    }
   
    public function index(Request $request)
    {      
        $this->validate($request, [
            'empresa'=>'nullable|string',
            'programa'=>'nullable|string',
            'periodo'=>'nullable|date'
        ]);

        $periodo = $request->query->get('periodo');  
        

        if ($periodo =='') {
            return view('Presidencia.estadoobras.index');
        } else {
            
            $empresa = $request->query->get('empresa');
            $programa = $request->query->get('programa');

            $dt = Carbon::parse($periodo);
            $periodoBusqueda = ($dt->month<10) ? '0'.$dt->month.$dt->year : $dt->month.$dt->year;


            $estadoobras = EstadoObras::empresa($empresa)
                                        ->programa($programa)
                                        ->where('periodo',$periodoBusqueda)->orderBy('nom_emp', 'asc')->Paginate(1000);

            $dt->formatLocalized('%B');
            $periodoMostrar = $dt->format('F\\, Y');
            return view('Presidencia.estadoobras.index',compact('estadoobras','periodo','periodoMostrar','empresa','programa'));
        }
    }
    public function empresas(Request $request)
    {      
        $this->validate($request, [
            'periodo'=>'date'
        ]);
  
        
        $periodo = $request->input("periodo");

        if ($periodo =='') {
            return;
        } else {
            $dt = Carbon::parse($periodo);
            $periodo = ($dt->month<10) ? '0'.$dt->month.$dt->year : $dt->month.$dt->year;

            $empresas = DB::table('iprodha.vw_presi_pagosobras')->select('nom_emp')->where('periodo', '=', $periodo)->distinct()->orderBy('nom_emp', 'asc')->get();

            return $empresas ;
        }
    }
    public function programas(Request $request)
    {      
        $this->validate($request, [
            'periodo'=>'date'
        ]);
        
        $periodo = $request->input("periodo");

        if ($periodo =='') {
            return;
        } else {
            $dt = Carbon::parse($periodo);
            $periodo = ($dt->month<10) ? '0'.$dt->month.$dt->year : $dt->month.$dt->year;

            $programas = DB::table('iprodha.vw_presi_pagosobras')->select('operatoria')->where('periodo', '=', $periodo)->distinct()->orderBy('operatoria', 'asc')->get();

            return $programas ;
        }
    }

    public function create()
    {
       
    }

    public function store(Request $request)
    {

    }
    
    public function show($id)
    {
       
    }
    
    public function edit(Request $request, $id)
    {

    }

    public function update(Request $request, $id)
    {
        
    }
    
    public function destroy($id)
    {
        
    }

}
