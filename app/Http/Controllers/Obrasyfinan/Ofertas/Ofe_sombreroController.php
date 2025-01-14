<?php

namespace App\Http\Controllers\Obrasyfinan\Ofertas;
use Illuminate\Support\Facades\DB;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Ofe_sombrero;
use App\Models\Iprodha\Ofe_conceptosombrero;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Ofe_sombreroController extends Controller
{
    public function index($idobra)
    {
        $unaObra = Ofe_obra::find(base64url_decode($idobra));
        $sombrerosxobra =  $unaObra->getSombrero;
        return view('Obrasyfinan.Ofertas.ofesombrero.index',compact('unaObra','sombrerosxobra'));
    }
    public function create($idobra)
    {
        $idobra = base64url_decode($idobra);
        $unaObra = Ofe_obra::find($idobra);
        $losConceptos = DB::table('iprodha.Ofe_conceptosombrero')
        ->whereNotIn('idconceptosombrero', Ofe_sombrero::select('idconceptosombrero')->where('Ofe_sombrero.idobra','=', $idobra))
        ->get();
        return view('Obrasyfinan.Ofertas.ofesombrero.crear',compact('unaObra','losConceptos'));
    }
    public function editar($idobra)
    {
        $unaObra = Ofe_obra::find(base64url_decode($idobra));
        $sombrerosxobra =  $unaObra->getSombrero ;        
        $losConceptos = Ofe_conceptosombrero::all();
        return view('Obrasyfinan.Ofertas.ofesombrero.editar',compact('unaObra','sombrerosxobra','losConceptos'));
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'conceptos' => 'required'
        ], [
            'conceptos.required' => 'No hay concepto seleccionado.'
        ]);
     
        $ar_onceptos=array();
        $ar_valores=array();

        $items = 0;
        $todoOK = true;
        
        foreach ($request->input('conceptos') as $indice => $i) {
                array_push($ar_onceptos, $i);
                $items++;
        }
        foreach ($request->input('valores') as $indice => $i) {
            if($i!=null){
                array_push($ar_valores, $i);
            }
        }
        for($p = 0; $p < $items; $p++) {
            if($ar_valores[$p] < 0 || $ar_valores[$p]>100){
                $todoOK=false;
                return redirect()->route('ofesombreroxobra.crear', base64url_encode($request->input('idobra')))->with('error', 'Los valores deben estar comprendidos entre 0 y 100.');
            }
        }
        if($todoOK){
            for($p = 0; $p < $items; $p++) {
                Ofe_sombrero::create([
                    'idobra' => $request->input('idobra'),
                    'idconceptosombrero' => $ar_onceptos[$p],
                    'valor' => $ar_valores[$p]
                ]);
                // $sombre = new Ofe_sombrero;
                // $sombre->idobra = $request->input('idobra');
                // $sombre->idconceptosombrero = $ar_onceptos[$p];
                // $sombre->valor = $ar_valores[$p];
                // $sombre->save(); 
            }
        }else{
            return redirect()->route('ofesombreroxobra.crear', base64url_encode($request->input('idobra')))->with('error', 'Los valores deben estar comprendidos entre 0 y 100.');
        }
        return redirect()->route('ofesombreroxobra.indexx',base64url_encode($request->input('idobra')));
    } 

    
    public function destroy($idobra, $idsombrero)
    {
        $unConcepto = Ofe_sombrero::where('idobra','=', $idobra)
        ->where('idconceptosombrero','=', $idsombrero)->first();
        $unConcepto->delete(); 
        return redirect()->route('ofesombreroxobra.indexx', base64url_encode($idobra))->with('mensaje', 'Se borro el concepto con exito.');
    }

    public function update(Request $request, $idobra)
    {        
        $validatedData = $request->validate([
            'conceptos' => 'required'                
        ], [
            'conceptos.required' => 'No hay concepto seleccionado.'
        ]);
        
        $input  = $request->all(); 
        $ar_onceptos=array();
        $ar_valores=array();
        $items=0;
        $valores=$request->valores;
        $conceptos=$request->conceptos;
        
        foreach ($request->input('conceptos') as $indice => $i) {
                array_push($ar_onceptos, $i);
                $items++;
        }
        foreach ($request->input('valores') as $indice => $i) {
            if($i!=null){
                array_push($ar_valores, $i);
            }
        }
        for($p = 0; $p < $items; $p++) {
            $sombre = Ofe_sombrero::where('idobra','=',$idobra)
            ->where('idconceptosombrero','=',$ar_onceptos[$p])->first();
            $sombre->valor = $ar_valores[$p];
            $sombre->save();
        }
        return redirect()->route('ofesombreroxobra.indexx', base64url_encode($idobra))->with('mensaje', 'Concepto de sombrero se modifico con exito.');
        // return redirect()->route('ofeobra.index');
        // return redirect()->route('categorialaboral.index')->with('mensaje','Concepto de sombrero se modifico con exito.');
    }
}
