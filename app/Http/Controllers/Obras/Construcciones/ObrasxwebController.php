<?php

    namespace App\Http\Controllers\Obras\Construcciones;

    use App\Models\Iprodha\ob_obrasxweb;
    use App\Models\Silverol\Vw_ob_ObrasParaFoja;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

class ObrasxwebController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
             $this->middleware('permission:VER-OBRAWEB|CREAR-OBRAWEB|EDITAR-OBRAWEB|BORRAR-OBRAWEB', ['only' => ['index']]);
             $this->middleware('permission:CREAR-OBRAWEB', ['only' => ['create','store']]);
             $this->middleware('permission:EDITAR-OBRAWEB', ['only' => ['edit','update']]);
             $this->middleware('permission:BORRAR-OBRAWEB', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
        $numero = $request->query->get('numero');
        if (!isset($numero)) {
            $Obras = Vw_ob_ObrasParaFoja::orderBy('num_obr')->get();
        } else{
            $Obras = Vw_ob_ObrasParaFoja::where('num_obr', '=', $numero)->get();
        }
        // $Obras = Vw_ob_ObrasParaFoja::where('num_obr', '=', 5669)->get();
        // return $Obras;
        return view('obras.Construcciones.Obrasxweb.index',compact('Obras'));
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
        $ExisteObra = ob_obrasxweb::find($id);
        // return $ExisteObra;
        if(!empty($ExisteObra)){
            // return 'Si existe';
            $ExisteObra->foja = $request->input('foja');
            $ExisteObra->cupo = $request->input('cupo');
            $ExisteObra->save();
        }else{
            // return 'No existe';
            $ObraWeb = new ob_obrasxweb;
            $ObraWeb->id_obr = $id;
            $ObraWeb->foja = $request->input('foja');
            $ObraWeb->cupo = $request->input('foja');
            $ObraWeb->save();
        }
        // return $ExisteObra;
        return redirect()->route('obraweb.index')->with('mensaje','La Obra se modifico con exito.');                                                   
    }

    
    public function update(Request $request, $id)
    {
            
    }

    
    public function destroy($id)
    {
        
    }
}