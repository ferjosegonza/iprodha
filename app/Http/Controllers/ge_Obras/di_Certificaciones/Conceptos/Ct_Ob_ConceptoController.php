<?php
namespace App\Http\Controllers\ge_Obras\di_Certificaciones\Conceptos;

use Illuminate\Http\Request;
use App\Models\Iprodha\Ob_Conceptos; // importo el modelo/s a utilizar

use App\Http\Controllers\Controller;  // uso Controller para poder extenderlo

class  Ct_Ob_ConceptoController extends Controller  //extiende de Controller
{

    function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('permission:ADMIN|VER-OB_CONCEPTO', ['only' => ['index']]);
    }
    
    public function index(Request $request)
    {        
       // $descripcion = $request->query->get('descripcion');

        //$vConceptos = Ob_Conceptos::descripcion($descripcion)->get();
        
        //$vConceptos = Ob_Conceptos::pluck('id_concepto','descripcion');

        $vConceptos = Ob_Conceptos::orderBy('descripcion')->paginate(10);

       return view('ge_Obras.di_Certificaciones.ob_concepto.index',compact('vConceptos'));
      
    }

    public function edit(Request $request,$id_concepto)
    {
        //return $id_concepto;

        $vConceptos = Ob_Conceptos::find($id_concepto);
        return view('ge_Obras.di_Certificaciones.ob_concepto.editar',compact('vConceptos'));
    }
}