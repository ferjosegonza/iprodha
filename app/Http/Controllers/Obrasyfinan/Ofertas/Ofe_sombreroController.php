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
        $unaObra = Ofe_obra::find($idobra);
        $sombrerosxobra =  $unaObra->getSombrero;
        return view('Obrasyfinan.Ofertas.ofesombrero.index',compact('unaObra','sombrerosxobra'));
    }
    public function create($idobra)
    {
        $unaObra = Ofe_obra::find($idobra);
        $losConceptos = DB::table('iprodha.Ofe_conceptosombrero')
        ->whereNotIn('idconceptosombrero', Ofe_sombrero::select('idconceptosombrero')->where('Ofe_sombrero.idobra','=', $idobra))
        ->get();
        return view('Obrasyfinan.Ofertas.ofesombrero.crear',compact('unaObra','losConceptos'));
    }
    public function editar($idobra)
    {
        $unaObra = Ofe_obra::find($idobra);
        $sombrerosxobra =  $unaObra->getSombrero ;        
        $losConceptos = Ofe_conceptosombrero::all();
        return view('Obrasyfinan.Ofertas.ofesombrero.editar',compact('unaObra','sombrerosxobra','losConceptos'));
    }
    public function store(Request $request)
    {
       
        $input  = $request->all();         
        $ar_onceptos=array();
        $ar_valores=array();
        $items=0;
        $todoOK=true;
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
            if($ar_valores[$p]<0 || $ar_valores[$p]>100){
                $todoOK=false;
                return redirect()->route('ofesombreroxobra.crear',$request->input('idobra'))->with('error', 'Los valores deben estar comprendidos entre 0 y 100.');
            }
        }
        if($todoOK){
            for($p = 0; $p < $items; $p++) {
                $sombre = new Ofe_sombrero;
                $sombre->idobra = $request->input('idobra');
                $sombre->idconceptosombrero = $ar_onceptos[$p];
                $sombre->valor = $ar_valores[$p];
                $sombre->save(); 
            }
        }else{
            //return redirect()->route('ofesombreroxobra.index',$request->input('idobra'))->withErrors($validatedData);
            //return redirect('ofesombreroxobra.index')->with('error', 'Valores no permitidos');
            
            //return redirect('/')->with('error', 'Error string');
            return redirect()->route('ofesombreroxobra.crear',$request->input('idobra'))->with('error', 'Los valores deben estar comprendidos entre 0 y 100.');
        }
        
        //return redirect('/ofesombreroxobra')->route('ofesombreroxobra.indexx',$request->input('idobra'));
        return redirect()->route('ofesombreroxobra.indexx',$request->input('idobra') );
    } 

    
    public function destroy($idobra,$idsombrero)
    {
        $unConcepto = Ofe_sombrero::where('idobra','=', $idobra)
        ->where('idconceptosombrero','=', $idsombrero)->first();
        $unConcepto->delete(); 
        return redirect()->route('ofesombreroxobra.indexx',$idobra );
    }

    public function update(Request $request, $idobra)
    {        
        $validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            /*'denominacion' => 'required|min:5|max:80|string',
            'unidad' => 'required|min:1|integer',
            'cantidad' => 'required|min:1|integer', 
            'costounitario' => 'required|min:1|integer', */

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
        return redirect()->route('ofeobra.index');
    }
}
