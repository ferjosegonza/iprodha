<?php

    namespace App\Http\Controllers\Obras\Construcciones;

    use App\Models\Iprodha\Ob_Cupo_x_Obra;
    use App\Models\Iprodha\Vw_ob_ParaCargaCupo;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

class CupoxobraController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
            $this->middleware('permission:VER-CUPOOBRA|CREAR-CUPOOBRA|EDITAR-CUPOOBRA|BORRAR-CUPOOBRA', ['only' => ['index']]);
            $this->middleware('permission:CREAR-CUPOOBRA', ['only' => ['create','store']]);
            $this->middleware('permission:EDITAR-CUPOOBRA', ['only' => ['edit','update']]);
            $this->middleware('permission:BORRAR-CUPOOBRA', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
        $numero = $request->query->get('numero');
        if (!isset($numero)) {
            $Obras = Vw_ob_ParaCargaCupo::orderBy('num_obr')->get();
        } else{
            $Obras = Vw_ob_ParaCargaCupo::where('num_obr', '=', $numero)->get();
        }
        return view('obras.Construcciones.Cupoxobra.index',compact('Obras'));
    }

    
    public function create()
    {
    
    }

    
    public function store(Request $request)
    {
       return $request;
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Request $request, $id)
    {
        $this->validate($request, [
             'cupo' => 'required|between:0,99.99'
        ]);
        $cupo = str_replace( ['$', ','], '', $request->input('cupo'));
        $datosObra = Vw_ob_ParaCargaCupo::where('id_obr', $id)->first();
        $cupoExiste = Ob_Cupo_x_Obra::where('id_obr', $datosObra->id_obr)->where('anio', $datosObra->aÑo)->where('mes', $datosObra->mes)->first();

        if(!empty($cupoExiste)){
            $cupoExiste->cupo = $cupo;
            $cupoExiste->save();
            return redirect()->route('cupoobra.index')->with('mensaje','Se modifico el cupo para obra numero: '.$datosObra->num_obr. ' con exito');
        }else {
            $nuevoCupo = new Ob_Cupo_x_Obra;
            $nuevoCupo->id_obr = $datosObra->id_obr;
            $nuevoCupo->anio = $datosObra->aÑo;
            $nuevoCupo->mes = $datosObra->mes;
            $nuevoCupo->cupo = $cupo;
            $nuevoCupo->save();
            return redirect()->route('cupoobra.index')->with('mensaje','La obra numero: '.$datosObra->num_obr.' se genero el cupo con exito.');
        }                                                       
    }

    
    public function update(Request $request, $id)
    {
            
    }

    
    public function destroy($id)
    {
        
    }
}