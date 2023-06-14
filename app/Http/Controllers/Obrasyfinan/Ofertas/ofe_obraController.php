<?php
namespace App\Http\Controllers\Obrasyfinan\Ofertas;

use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Localidad;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Ob_situacion;
use App\Models\Iprodha\Ofe_tipocontratoferta;
use App\Models\Iprodha\Ofe_estadoxobra;
use App\Models\Iprodha\Ofe_obraestado;
use App\Models\Iprodha\Ofe_sombrero;
use App\Models\Iprodha\Ofe_item;
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Vw_ofe_obra_valida;
use App\Models\Iprodha\Vw_ofe_items;
use App\Models\Iprodha\Vw_ofe_cronograma;
use App\Models\Iprodha\Vw_ofe_crono_desem;
use App\Models\Iprodha\Membrete;
use App\Http\Controllers\Obrasyfinan\Ofertas\ofe_obraController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PDF;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Obrasyfinan\Ofertas\RechazarOfeObra;
use App\Mail\Obrasyfinan\Ofertas\AceptarOfeObra;
use App\Mail\Obrasyfinan\Ofertas\CrearOfeObra;


class ofe_obraController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-OFEOBRA|CREAR-OFEOBRA|EDITAR-OFEOBRA|BORRAR-OFEOBRA', ['only' => ['index']]);
        $this->middleware('permission:CREAR-OFEOBRA', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-OFEOBRA', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-OFEOBRA', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
        $LaEmpresa = Empresa::where('iduserweb','=',Auth::user()->id)->first();
        if(empty($LaEmpresa)) {
            $Ofertas = Ofe_obra::all();
            $modifica=true;
        }else{
            $Ofertas = Ofe_obra::where('idempresa','=' ,$LaEmpresa->id_emp)->get();
            $modifica =false;
        }
        
        return view('Obrasyfinan.Ofertas.ofeobra.index',compact('Ofertas'));
    }
  /*  public function sombrerosxoferta ($idobra){
        $laObra = Ofe_obra::find($idobra);
        $sombrerosxobra =  $laObra->getConceptoSombrero ;
        return $sombrerosxobra ;
        return view('Obrasyfinan.Ofertas.ofesombrero.index',compact('laObra','sombrerosxobra'));
    } */
    public function create(Request $request)
    {
        $input = $request->all();
        // $Localidad = Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc');
        $Localidad = Localidad::orderBy('nom_loc')->get();
        // if(Auth::user()->hasRole('EMPRESA')){
        //     $Empresa= Empresa::where('iduserweb' ,Auth::user()->id)->orderBy('nom_emp')->pluck('nom_emp','id_emp');
        // }else{
        //     $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        // }
        // $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        $Empresa= Empresa::orderBy('nom_emp')->get();
        $TipoContrato = Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer'); 
        $TipoSituacion = Ob_situacion::pluck('descripcion', 'id_situacion');
        return view('Obrasyfinan.Ofertas.ofeobra.crear',compact('Localidad','Empresa','TipoContrato', 'TipoSituacion'));
    }

   public function store(Request $request)
    {
        $this->validate($request, [
            'nomobra' => 'required|min:10|max:150|string',
            'idexpediente' => 'required|min:0|max:999999|numeric',
            'idloc' => 'required',
            'idempresa' => 'required',
            'idtipocontrato' => 'required',
            'publica' => 'required',
            'anioymes' => 'required',
            'plazo' => 'required|min:1|max:999|numeric',
        ], [
            'publica.required' => 'La fecha de publicacion no puede estar vacio.'
        ]);

        $montotope = str_replace( ['$', ','], '', $request->input('montotope'));

        $laOferta = Ofe_obra::create([
            'nomobra' => strtoupper($request->input('nomobra')),
            'idloc' => $request->input('idloc'),
            'idempresa' => $request->input('idempresa'),
            'idtipocontratofer' =>  $request->input('idtipocontrato'),
            'publica' => $request->input('publica'),
            'idexpediente' => $request->input('idexpediente'),
            'montotope' => $montotope,
            'plazo' => $request->input('plazo'),
            'aniocotizacion' => date("Y", strtotime($request->input('anioymes'))),
            'mescotizacion' => date("m", strtotime($request->input('anioymes'))),
            'numofer' => 1,
        ]);

        if($request->input('idsituacion')){
            $laOferta->update([
                'id_situacion' => $request->input('idsituacion')
            ]);
        }

        Ofe_estadoxobra::create(['idobra' => $laOferta->idobra, 'idestado' => 1]);
        $email = Empresa::where('id_emp', $laOferta->idempresa)->first()->email;
        $datOfe = Ofe_obra::where('idobra', $laOferta->idobra)->first();

        try {
            Mail::to($email)->send(new CrearOfeObra($datOfe->getEmpresa->nom_emp, $datOfe->nomobra));
            return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.');
        } catch (Throwable $e) {
            return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.')->with('error', 'No se puedo enviar el email');
        }    
    }
    
    public function edit( $idobra)
    {
        $unaOferta = Ofe_obra::find(base64url_decode($idobra));
        $Localidad= Localidad::pluck('nom_loc','id_loc');

        if(Auth::user()->hasRole('EMPRESA')){
            $Empresa = Empresa::where('iduserweb','=',Auth::user()->id)->get();
            $TipoContrato = Ofe_tipocontratoferta::where('idtipocontratofer', '=', $unaOferta->idtipocontratofer)->pluck('tipocontratofer','idtipocontratofer');
        }else{
            $Empresa = Empresa::get(); 
            $TipoContrato = Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer');
        }
            
        return view('Obrasyfinan.Ofertas.ofeobra.editar',compact('unaOferta','Localidad','Empresa','TipoContrato'));
    }

    public function show($idobra)
    { 
        $idobra = base64url_decode($idobra);
        $data = Vw_ofe_obra_valida::where('idobra', $idobra)->first();
        $items = Vw_ofe_items::where('idobra', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $obra = Ofe_obra::where('idobra','=', $idobra)->first();
        $desembolsos = Vw_ofe_crono_desem::where('idobra','=', $idobra)->orderBy('mes')->get();
        return view('Obrasyfinan.Ofertas.ofeobra.show',compact('data','items','cronograma', 'obra', 'sombreros', 'desembolsos'));
    }   

    
    public function update(Request $request, $idobra)
    {   
        if (Auth::user()->hasRole('EMPRESA')){
            $this->validate($request, [
                'anioymes' => 'required',
                'plazo' => 'required|min:1|max:999|numeric',
            ]);

            $laOferta = Ofe_obra::find(base64url_decode($idobra));
            $laOferta->update([
                'plazo' => $request->input('plazo'),
                'aniocotizacion' => date("Y", strtotime($request->input('anioymes'))),
                'mescotizacion' => date("m", strtotime($request->input('anioymes'))),
            ]);

        }else{
            $this->validate($request, [
                'nomobra' => 'required|min:10|max:150|string',
                'idexpediente' => 'required|min:0|max:999999|numeric',
                'idloc' => 'required',
                'idempresa' => 'required',
                'idtipocontrato' => 'required',
                'anioymes' => 'required',
                'publica' => 'required',
                'plazo' => 'required|min:1|max:999|numeric',
            ]);
            $montotope = str_replace( ['$', ','], '', $request->input('montotope'));
            $laOferta = Ofe_obra::find(base64url_decode($idobra));
            $laOferta->update([
                'nomobra' => strtoupper($request->input('nomobra')),
                'idexpediente' => $request->input('idexpediente'),
                'idloc' => $request->input('idloc'),
                'idempresa' => $request->input('idempresa'),
                'plazo' => $request->input('plazo'),
                'idtipocontratofer' => $request->input('idtipocontrato'),
                'publica' => $request->input('publica'),
                'aniocotizacion' => date("Y", strtotime($request->input('anioymes'))),
                'mescotizacion' => date("m", strtotime($request->input('anioymes'))),
                'montotope' => $montotope,
            ]);

        }
        return redirect()->route('ofeobra.index')->with('mensaje','La Oferta '.$laOferta->nomobra.' editado con éxito!.');            
    }
        
    public function destroy($idobra)
    {     
        return redirect()->route('ofeobra.index')->with('mensaje','Funcionalidad en desarrollo.');
        // return Ofe_estadoxobra::where('idobra', '=', $idobra)->get();
        // Ofe_estadoxobra::where('idobra', '=', $idobra)->delete();
        // return 1;
        // $laOferta = Ofe_obra::find($idobra);
        // $laOferta->delete();
        // return redirect()->route('ofeobra.index')->with('mensaje','Oferta '. $laOferta->nomobr.' borrada con éxito!.');
    }    

    public function presentarOferta($idobra)
    { 
        $idobra = base64url_decode($idobra);
        $data = Vw_ofe_obra_valida::where('idobra', $idobra)->first();
        $items = Vw_ofe_items::where('idobra', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $obra = Ofe_obra::where('idobra','=', $idobra)->first();
        $desembolsosPorMes = Vw_ofe_crono_desem::where('idobra','=', $idobra)->orderBy('mes')->get();
        // $desembolsosPorMes = $this->desembolsoPorMes($idobra);
        return view('Obrasyfinan.Ofertas.ofeobra.presentar')
            ->with('data', $data)
            ->with('items', $items)
            ->with('cronograma', $cronograma)
            ->with('obra', $obra)
            ->with('sombreros', $sombreros)
            ->with('desembolsos', $desembolsosPorMes);
    }

    public function presentarSave($idobra){
        $idobra = base64url_decode($idobra);
        Ofe_estadoxobra::create(['idobra' => $idobra, 'idestado' => 2]);
        return redirect()->route('ofeobra.index')->with('mensaje','Se presentó la oferta de obra con exito.');
    }

    public function verValidarOferta($idobra){
        $idobra = base64url_decode($idobra);
        $data = Vw_ofe_obra_valida::where('idobra', $idobra)->first();
        $obra = Ofe_obra::where('idobra', $idobra)->first();
        $cronograma = Vw_ofe_cronograma::where('idobra', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', $idobra)->get();
        $items = Vw_ofe_items::where('idobra', $idobra)->get();
        return view('Obrasyfinan.Ofertas.ofeobra.validar',compact('obra','data', 'cronograma', 'sombreros', 'items'));
    }

    public function validarOferta($idobra)
    {
        $idobra = base64url_decode($idobra);

        $datOfe = Ofe_obra::where('idobra', $idobra)->first();
        $email = strval(Empresa::where('id_emp', $datOfe->idempresa)->first()->email);
        $result = null;
        $procedureName = 'iprodha.SP_OFE_MIGRAOBRA';
        $bindings = [
            'idobra'  => $idobra,
            'result' => [
                'value' => &$result,
                'length' => 1000,
            ],
        ];
        
        $succeeded = DB::executeProcedure($procedureName, $bindings);

        if($succeeded) {
            Ofe_estadoxobra::create(['idobra' => $idobra, 'idestado' => 3]);
            try {
                Mail::to($email)->send(new AceptarOfeObra($datOfe->getEmpresa->nom_emp, $datOfe->nomobra));
                return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result);
            } catch (Throwable $e) {
                return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result)->with('error', 'No se puedo enviar el email');
            } 
        }
        else {
            return redirect()->route('ofeobra.vervalidar', $idobra)->with('error','Problemas con el procedimiento.');
        }
    }

    public function rechazarOferta(Request $request, $idobra)
    {
        $idobra = base64url_decode($idobra);
        $comentario = $request->input('comentario');
        $name = $request->input('nom_emp');
        $oferta = $request->input('nombobra');
        $subject = "Asunto del correo";
        $datOfe = Ofe_obra::where('idobra', $idobra)->first();
        $email = Empresa::where('id_emp', $datOfe->idempresa)->first()->email;

        
        Ofe_estadoxobra::create(['idobra' => $idobra, 'idestado' => 4]);
        Ofe_estadoxobra::create(['idobra' => $idobra, 'idestado' => 1]);
        
        try {
            Mail::to($email)->send(new RechazarOfeObra($name, $oferta, $comentario));
            return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.');
        } catch (Throwable $e) {
            return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.')->with('error', 'No se pudo mandar el email');
        }
    }

    public function indexEstado(Request $request)
    {
        $LaEmpresa = Empresa::where('iduserweb','=',Auth::user()->id)->first();
        if(empty($LaEmpresa)) {
            $Ofertas = Ofe_obra::all();
            $modifica=true;
        }else{
            $Ofertas = Ofe_obra::where('idempresa','=' ,$LaEmpresa->id_emp)->get();
            $modifica =false;
        }        
        return view('Obrasyfinan.Ofertas.estadosxobra.index',compact('Ofertas'));
    }

    public function verEstados($idobra)
    {   
        $obra = Ofe_obra::find($idobra)->get()->first();
        $estadosobra = Ofe_estadoxobra::where('idobra','=',$idobra)->get(); 
        $estados = Ofe_obraestado::orderBy('idestado', 'asc')->get();
        return view('Obrasyfinan.Ofertas.ofeobra.verEstados')
        ->with('obra',$obra)
        ->with('estadosobra',$estadosobra)
        ->with('estados',$estados);
    }

    public function indexEstadoBuscar(Request $request)
    {
        $busqueda='%'.$request->name.'%';
        $busqueda= strtoupper($busqueda);
        $Ofertas = Ofe_obra::where('nomobra','like', $busqueda)->get();   
        if($Ofertas == null)
        {
            $Ofertas = Ofe_obra::all();
            return view('Obrasyfinan.Ofertas.estadosxobra.index')
            ->with("Ofertas", $Ofertas)
            ->with('mensaje','No se encontró una obra con ese nombre.');
        }
        else
        return view('Obrasyfinan.Ofertas.estadosxobra.index',compact('Ofertas'));
    }   

    public function recuperarSubItems(Request $request){
        $subitems = Ofe_subitem::where('iditem', '=', $request->iditem)->get();
        $response['data'] = $subitems;
        return response()->json(['response' => $response]);
    }

    public function pdf1($idobra){
        $pdf = app('dompdf.wrapper');
        
        $obra = Ofe_Obra::where('idobra', '=', $idobra)->first(); 
        $vw=Vw_ofe_items::where('idobra', '=', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $data = Vw_ofe_obra_valida::where('idobra', '=', $idobra)->first();
        $texto = DB::table('iprodha.membrete')->get();       
        return $pdf->loadView('Obrasyfinan.Ofertas.ofeobra.pdf1',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto])
                                    ->setPaper('a4', 'landscape')
                                    ->stream('obraPresentada.pdf');     
        
        
    }

    public function pdf2($idobra){
        $pdf = app('dompdf.wrapper');
        
        $obra = Ofe_Obra::where('idobra', '=', $idobra)->first(); 
        $vw=Vw_ofe_items::where('idobra', '=', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $data = Vw_ofe_obra_valida::where('idobra', '=', $idobra)->first();

        $texto = DB::table('iprodha.membrete')
                    ->select('texto_1')
                    ->get();  

        $texto = json_decode($texto);
        return $pdf->loadView('Obrasyfinan.Ofertas.ofeobra.pdf2',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto])
                                    ->setPaper('a4', 'portrait')
                                    ->stream('obraPresentada.pdf');
        
    }

    public function pdfItems($id, $opc){
        $pdf = app('dompdf.wrapper');

        $id = base64url_decode($id);
        $ofeobra = Ofe_obra::find($id);
        $vw = Vw_ofe_items::where('idobra', $id)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', $id)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', $id)->get();

        $conceptos = Ofe_sombrero::select('iprodha.ofe_sombrero.idobra', 'iprodha.ofe_sombrero.valor', 'iprodha.ofe_conceptosombrero.idconceptosombrero', 'iprodha.ofe_conceptosombrero.conceptosombrero' )
                        ->join('iprodha.ofe_conceptosombrero', 'iprodha.ofe_sombrero.idconceptosombrero', '=', 'iprodha.ofe_conceptosombrero.idconceptosombrero')
                        ->where('idobra', $id)
                        ->get();
        // return $conceptos;

        $data = Vw_ofe_obra_valida::where('idobra', $id)->first();
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);

        switch ($opc) {
            case 1:
                $tipo = 'VIVIENDA';
                $items = Vw_ofe_items::where('idobra', $id)->where('cod_tipo', 1)->orderBy('orden')->get();
                break;
            case 2:
                $tipo = 'INFRAESTRUCTURA';
                $items = Vw_ofe_items::where('idobra', $id)->where('cod_tipo', 2)->orderBy('orden')->get();
                break;

            case 3:
                $tipo = 'GENERAL';
                $items = Vw_ofe_items::where('idobra', $id)->orderBy('orden')->get();
                break;

            default:
                # code...
                break;
        }
        
        return $pdf->loadView('Obrasyfinan.Ofertas.informes.items-pdf',[
                    'obra' => $ofeobra,
                    'tipo' => $tipo, 
                    'items' => $items,
                    'opc'=> $opc, 
                    'conceptos'=> $conceptos,
                    'data'=>$data, 
                    'sombreros'=>$sombreros, 
                    'cronograma'=>$cronograma, 
                    'texto'=>$texto])->setPaper('legal', 'portrait')
                                    ->stream('ItemsDeLaObra.pdf');
    } 

    public function pdfDsmxmes($id){
        $pdf = app('dompdf.wrapper');
        $id = base64url_decode($id);
        $ofeobra = Ofe_obra::find($id);
        $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();
        $data = Vw_ofe_obra_valida::where('idobra', $id)->first();
        // return $this->deseAcuPormes($id);
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);
        
        return $pdf->loadView('Obrasyfinan.Ofertas.informes.dsmpormes-pdf',[
                    'obra' => $ofeobra,
                    'data'=>$data,
                    'desembolsos'=>$desembolsos,
                    'texto'=>$texto
                    ])  ->setPaper('legal', 'portrait')
                        ->stream('ItemsDeLaObra.pdf');
    } 

    public function pdfIncItems($id){
        $pdf = app('dompdf.wrapper');
        $id = base64url_decode($id);
        $ofeobra = Ofe_obra::find($id);
        $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();
        $data = Vw_ofe_obra_valida::where('idobra', $id)->first();
        $items = Ofe_item::where('idobra', $id)->orderBy('orden')->get();
        // return $this->deseAcuPormes($id);
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);
        
        return $pdf->loadView('Obrasyfinan.Ofertas.informes.incitems-pdf',[
                    'obra' => $ofeobra,
                    'data'=>$data,
                    'items'=>$items,
                    'texto'=>$texto
                    ])  ->setPaper('legal', 'portrait')
                        ->stream('ItemsDeLaObra.pdf');
    } 

    public function pdfCurvaDes($id){
        $pdf = app('dompdf.wrapper');
        $id = base64url_decode($id);
        $monto = [];
        $meses = [];
        $acu = 0;

        $ofeobra = Ofe_obra::find($id);
        $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();

        for ($i=0; $i <= $ofeobra->plazo; $i++) { 
            array_push($meses, 'Mes '.$i);
        }

        foreach ($desembolsos as $desembolso) {
            $acu += $desembolso->costo;
            array_push($monto);
        }
        // type: 'line',
        // data: {
        //     labels: meses,
        //     datasets: [{
        //     label: 'Desembolso por mes',
        //     data: monto,
        //     borderWidth: 1,
        //     pointStyle: 'rect',
        //     }]
        // },
        // plugins: [ChartDataLabels],
        // options: {
        //     plugins: {
        // // Change options for ALL labels of THIS CHART
        //         datalabels: {
        //             font: {
        //                 size: 15
        //             },
        //         }
        //     },
        //     scales: {
        //     y: {
        //         beginAtZero: true
        //     },
        //     },
        // }
     
        $chartData = [
             "type" => 'line',
               "data" => [
                 "labels" => $meses,
                   "datasets" => [
                     [
                       "label" => "CURVA DE INVERSIONES", 
                       "data" => $monto,
                       "borderWidth" => 1,
                        "pointStyle" => 'rect',
                     ], 
                   ],
                ],
                "plugins" => ['ChartDataLabels']
             ]; 
        $chartData = json_encode($chartData);
        $chartURL = "https://quickchart.io/chart?width=300&height=200&c=".urlencode($chartData);
        $chartData = file_get_contents($chartURL); 
        $chart = 'data:image/png;base64, '.base64_encode($chartData);
    
        
        

        $ofeobra = Ofe_obra::find($id);
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $id)->orderBy('mes')->get();
        $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();
        $data = Vw_ofe_obra_valida::where('idobra', $id)->first();
        $items = Ofe_item::where('idobra', $id)->orderBy('orden')->get();
        // return $this->deseAcuPormes($id);
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);
        
        return $pdf->loadView('Obrasyfinan.Ofertas.informes.curvades-pdf',[
                    'obra' => $ofeobra,
                    'data'=>$data,
                    'items'=>$items,
                    'texto'=>$texto,
                    'cronograma' => $cronograma,
                    'desembolsos' => $desembolsos,
                    'chart'=> $chart
                    ])  ->set_option('isRemoteEnabled', true)
                        ->setPaper('legal', 'landscape')
                        ->stream('ItemsDeLaObra.pdf');
    } 
    // public function deseAcuPormes($id){
    //     $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();
    //     $deseAcuxmes = array();
    //     $acuMes = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->first()->costo;
    //     foreach ($desembolsos as $desembolso) {
    //         array_push($deseAcuxmes, (object)[
    //                             'mes' => $desembolso->mes,
    //                             'montomensual' => number_format($desembolso->costo, 2),
    //                             'montoacumulado' => number_format($acuMes, 2),
    //                      ]);
    //         $acuMes = $desembolso->costo;
    //     }

    //     return $deseAcuxmes = collect($deseAcuxmes)->sortBy('mes');
    // }

    // public function desembolsoPorMes($idobra){
    //     $ofeObra = Ofe_obra::find($idobra);
    //     $montos = array();
    //     $mes = 0;
    //     $montoMes = 0;
    //     $avanceTotal = 0;

    //     for ($i=1; $i <= $ofeObra->plazo; $i++) { 
    //         foreach ($ofeObra->getItems as $item) {
    //             foreach ($item->getCronograma as $cronograma) {
    //                 if($cronograma->mes == $i){
    //                     $montoMes += $cronograma->avance * $item->costo;
    //                 }
    //             }
    //         }
    //         array_push($montos, (object)[
    //             'mes' => $i,
    //             'montomensual' => $montoMes,
    //         ]);

    //         $montoMes = 0;
    //     }
    //     return $cronoDesembolso = collect($montos)->sortBy('mes');
    // }

    public function desembolsoPorMes($idobra){
        $ofeObra = Ofe_obra::find($idobra);
        $montos = array();
        $mes = 0;
        $montoMes = 0;
        $acumulado = 0;

        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();

        for ($i=1; $i <= $ofeObra->plazo; $i++) { 
            foreach ($cronograma as $crono) {
                if($crono->mes == $i){
                    $montoMes += $crono->importe;
                }
            }
            array_push($montos, (object)[
                'mes' => $i,
                'montomensual' => $montoMes,
                'acumulado' => $acumulado += $montoMes,
            ]);

            $montoMes = 0;
        }
        return $cronoDesembolso = collect($montos)->sortBy('mes');
    }

    public function prueba(){
        return view('Obrasyfinan.Ofertas.ofeobra.prueba');
    }

    // public function todasLasViviendasDeUnaObra(Ob_obra $obra){
    //     $viviendasTabla = array();
    //     foreach($obra->getEtapas as $etapa){
    //         foreach($etapa->getEntregas as $entrega){
    //             foreach ($entrega->getViviendas->sortBy('orden') as $vivienda) {
    //                 array_push($viviendasTabla, (object)[
    //                     'orden' => $vivienda->orden,
    //                     'etapa' => $etapa->nro_eta,
    //                     'entrega' => $entrega->num_ent,
    //                     'discap' => $vivienda->discap,
    //                     'partida' => $vivienda->partida,
    //                     'plano' => $vivienda->plano,
    //                     'seccion' => $vivienda->seccion,
    //                     'chacra' => $vivienda->chacra,
    //                     'manzana' => $vivienda->manzana,
    //                     'parcela' => $vivienda->parcela,
    //                     'finca' => $vivienda->finca,
    //                     'sup_fin' => $vivienda->sup_fin,
    //                     'sup_lot' => $vivienda->sup_lot,
    //                     'num_cal' => $vivienda->num_cal,
    //                     'nom_cal' => $vivienda->nom_cal,
    //                     'latitud' => $vivienda->latitud,
    //                     'longitud' => $vivienda->longitud,
    //                     'edificio' => $vivienda->edificio,
    //                     'piso' => $vivienda->piso,
    //                     'departamento' => $vivienda->departamento,
    //                     'escalera' => $vivienda->escalera]);
    //             }
    //         }
    //     }
    //     return $viviendasTabla = collect($viviendasTabla)->sortBy('orden');
    // }
}  
