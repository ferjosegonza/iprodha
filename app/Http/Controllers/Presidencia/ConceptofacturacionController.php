<?php

namespace App\Http\Controllers\Presidencia;

use App\Models\Quique\Conceptofacturacion;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class ConceptofacturacionController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-CONCEPTOFACTURACION|CREAR-CONCEPTOFACTURACION|EDITAR-CONCEPTOFACTURACION|BORRAR-CONCEPTOFACTURACION', ['only' => ['index']]);
        $this->middleware('permission:CREAR-CONCEPTOFACTURACION', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-CONCEPTOFACTURACION', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-CONCEPTOFACTURACION', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        $name = $request->query->get('name');

        if (!isset($name)) {
            $conceptosfacturacion = Conceptofacturacion::orderBy('concepto', 'asc')->get();
        } else {
            $conceptosfacturacion = Conceptofacturacion::whereRaw('UPPER(concepto) LIKE ?', ['%' . strtoupper($name) . '%'])->orderBy('concepto', 'asc')->get();
        }
        return view('Presidencia.conceptosfacturacion.index',compact('conceptosfacturacion'));
    }

    public function create(Request $request)
    {
        return view('Presidencia.conceptosfacturacion.crear');   
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'concepto' => 'required|string',
            'monto' => 'required|min:1|max:2|integer',
            'suma_o_resta' => 'required|min:-1|max:1|integer',
            'numero_fila' => 'required|integer',
            'fecha_baja'=> 'nullable|date',
            'numero_columna' => 'required|max:9|integer',
            'enx_Adju' => 'required|boolean',
            'cr' => 'required|boolean',
            'bn' => 'required|boolean',
            'mv' => 'required|boolean',
            'ch' => 'required|boolean',
            'forma_cap' => 'required|boolean',
            'pi' => 'required|boolean',
            'nota_credito' => 'required|boolean',
            'adel_cancela' => 'required|boolean',
            'ah' => 'required|boolean',
            'forma_neta' => 'required|boolean',
            'enmascara' => 'required|boolean',
            're_adju' => 'required|boolean',
            'entre_per' => 'required|boolean',
            'modifica_nouvi' => 'required|boolean',
            'modifica_uvi' => 'required|boolean',
            'capital' => 'required|boolean',
            'deuda_cap' => 'required|boolean',
            'forma_pura' => 'required|boolean',
            'aq' => 'required|boolean',
            'recargo' => 'required|boolean',
        ]);

        $input = $request->all();

        $modelo = new Conceptofacturacion;

        $modelo->concepto = $request->input('concepto');
        $modelo->monpor = $request->input('monto');
        $modelo->sumaoresta = $request->input('suma_o_resta');
        $modelo->nrofila = $request->input('numero_fila');
        $modelo->nrocolumna = $request->input('numero_columna');
        $modelo->fechabaja = $request->input('fecha_baja');
        $modelo->va_enxadju = $request->input('enx_Adju');
        $modelo->ve_cr = $request->input('cr');
        $modelo->ve_bn = $request->input('bn');
        $modelo->ve_mv = $request->input('mv');
        $modelo->ve_ch = $request->input('ch');
        $modelo->forma_cap = $request->input('forma_cap');
        $modelo->ve_pi = $request->input('pi');
        $modelo->ve_notacre = $request->input('nota_credito');
        $modelo->ve_adel_canc = $request->input('adel_cancela');
        $modelo->ve_ah = $request->input('ah');
        $modelo->forma_neta = $request->input('forma_neta');
        $modelo->enmascara = $request->input('enmascara');
        $modelo->ve_readju_comun = $request->input('re_adju');
        $modelo->ve_readju_entreper = $request->input('entre_per');
        $modelo->modifica_nouvi = $request->input('modifica_nouvi');
        $modelo->modifica_uvi = $request->input('modifica_uvi');
        $modelo->es_capital = $request->input('capital');
        $modelo->es_deuda_cap = $request->input('deuda_cap');
        $modelo->forma_pura = $request->input('forma_pura');
        $modelo->forma_aq = $request->input('aq');
        $modelo->forma_recargo = $request->input('recargo');
               
        $data = Conceptofacturacion::latest('idconcepto')->first();
        $modelo->idconcepto= $data['idconcepto'] +1;
        
        $data = Conceptofacturacion::where('concepto', $modelo->concepto)->first();
        
        if (isset($data['concepto'])) {
            return redirect()->route('conceptofacturacion.index')->with('alerta','Ya existe el Concepto.!');
        }

        $modelo->save();

        return redirect()->route('conceptofacturacion.index')->with('mensaje','El Concepto '.$modelo->concepto.' creado con exito.');
    }

    
    public function show( )
    {
        //
    }

    public function edit( $idconcepto)
    {
        $concepto = Conceptofacturacion::where('idconcepto', $idconcepto)->first();
        return view('Presidencia.conceptosfacturacion.editar',compact('concepto'));
    }

    
    public function update(Request $request, $idconcepto)
    {        
        $this->validate($request, [
            'concepto' => 'required|string',
            'monto' => 'required|min:1|max:2|integer',
            'suma_o_resta' => 'required|min:-1|max:1|integer',
            'numero_fila' => 'required|integer',
            'fecha_baja'=> 'nullable|date',
            'numero_columna' => 'required|max:9|integer',
            'enx_Adju' => 'required|boolean',
            'cr' => 'required|boolean',
            'bn' => 'required|boolean',
            'mv' => 'required|boolean',
            'ch' => 'required|boolean',
            'forma_cap' => 'required|boolean',
            'pi' => 'required|boolean',
            'nota_credito' => 'required|boolean',
            'adel_cancela' => 'required|boolean',
            'ah' => 'required|boolean',
            'forma_neta' => 'required|boolean',
            'enmascara' => 'required|boolean',
            're_adju' => 'required|boolean',
            'entre_per' => 'required|boolean',
            'modifica_nouvi' => 'required|boolean',
            'modifica_uvi' => 'required|boolean',
            'capital' => 'required|boolean',
            'deuda_cap' => 'required|boolean',
            'forma_pura' => 'required|boolean',
            'aq' => 'required|boolean',
            'recargo' => 'required|boolean',
        ]);

        $input = $request->all();
                
        $data = Conceptofacturacion::where('concepto', $input['concepto'])->first();
        
        if (isset($data['concepto'])) {
            if ($idconcepto != $data['idconcepto']) {
                return redirect()->route('conceptofacturacion.index')->with('alerta','Ya existe el nombre del Concepto Editado.!');
            }
        }

        $modelo = Conceptofacturacion::find($idconcepto);
            
        $modelo->concepto = $request->input('concepto');
        $modelo->monpor = $request->input('monto');
        $modelo->sumaoresta = $request->input('suma_o_resta');
        $modelo->nrofila = $request->input('numero_fila');
        $modelo->nrocolumna = $request->input('numero_columna');
        $modelo->fechabaja = $request->input('fecha_baja');
        $modelo->va_enxadju = $request->input('enx_Adju');
        $modelo->ve_cr = $request->input('cr');
        $modelo->ve_bn = $request->input('bn');
        $modelo->ve_mv = $request->input('mv');
        $modelo->ve_ch = $request->input('ch');
        $modelo->forma_cap = $request->input('forma_cap');
        $modelo->ve_pi = $request->input('pi');
        $modelo->ve_notacre = $request->input('nota_credito');
        $modelo->ve_adel_canc = $request->input('adel_cancela');
        $modelo->ve_ah = $request->input('ah');
        $modelo->forma_neta = $request->input('forma_neta');
        $modelo->enmascara = $request->input('enmascara');
        $modelo->ve_readju_comun = $request->input('re_adju');
        $modelo->ve_readju_entreper = $request->input('entre_per');
        $modelo->modifica_nouvi = $request->input('modifica_nouvi');
        $modelo->modifica_uvi = $request->input('modifica_uvi');
        $modelo->es_capital = $request->input('capital');
        $modelo->es_deuda_cap = $request->input('deuda_cap');
        $modelo->forma_pura = $request->input('forma_pura');
        $modelo->forma_aq = $request->input('aq');
        $modelo->forma_recargo = $request->input('recargo');
        $modelo->save();

        return redirect()->route('conceptofacturacion.index')->with('mensaje','Concepto '.$request->input('concepto').' editado con éxito!.');
    } 

    
    public function destroy($idconcepto)
    {        
        $concepto = Conceptofacturacion::where('idconcepto',$idconcepto)->first();
        $modelo = Conceptofacturacion::where('idconcepto',$idconcepto)->delete();

        return redirect()->route('conceptofacturacion.index')->with('mensaje','Concepto '.$concepto->concepto.' borrado con éxito!.');
    }
    public function index2()
    {

    }
}
