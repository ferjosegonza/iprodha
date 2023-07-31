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
use App\Models\Iprodha\Vw_ofe_crono_desem_ant;
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
            $Ofertas = Ofe_obra::orderBy('idobra', 'desc')->get();
            $modifica=true;
        }else{
            $Ofertas = Ofe_obra::where('idempresa','=' ,$LaEmpresa->id_emp)->orderBy('idobra', 'desc')->get();
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
            // 'idexpediente' => 'required|min:0|max:999999|numeric',
            'numExp' => 'required',
            'idloc' => 'required',
            'idempresa' => 'required',
            'idtipocontrato' => 'required',
            'publica' => 'required',
            'anioymes' => 'required',
            'plazo' => 'required|min:1|max:999|numeric',
        ], [
            'publica.required' => 'La fecha de publicacion no puede estar vacio.'
        ]);
        
        $numExp = $request->input('numExp');
        // $numExp = str_replace("/", "\/", $numExp);
        // return $exp = Expediente::where('exp_numero', 'like','%'.$numExp.'%')->first();
        // return DB::table('me.expedientes')  
        //         ->where('exp_numero', '=', '01478-K/03      ') 
        //         ->get();
        $exp = Expediente::where('exp_numero', $numExp.'      ')->first();

        if(is_null($exp)){
          return redirect()->route('ofeobra.create')->withInput()->with('error','El numero de expediente no se encuentra.');
        }

        $montotope = str_replace( ['$', ','], '', $request->input('montotope'));

        $laOferta = Ofe_obra::create([
            'nomobra' => strtoupper($request->input('nomobra')),
            'idloc' => $request->input('idloc'),
            'idempresa' => $request->input('idempresa'),
            'idtipocontratofer' =>  $request->input('idtipocontrato'),
            'publica' => $request->input('publica'),
            'idexpediente' => $exp->exp_doc_id,
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

        // try {
        //     Mail::to($email)->send(new CrearOfeObra($datOfe->getEmpresa->nom_emp, $datOfe->nomobra));
        //     return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.');
        // } catch (Throwable $e) {
        //     return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.')->with('error', 'No se puedo enviar el email');
        // }    
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.');
    }
    
    public function edit( $idobra)
    {
        $unaOferta = Ofe_obra::find(base64url_decode($idobra));
        // $Localidad= Localidad::pluck('nom_loc','id_loc');
        $Localidad= Localidad::orderBy('nom_loc')->get();
        $TipoSituacion = Ob_situacion::pluck('descripcion', 'id_situacion');
        if(Auth::user()->hasRole('EMPRESA')){
            $Empresa = Empresa::where('iduserweb','=',Auth::user()->id)->get();
            $TipoContrato = Ofe_tipocontratoferta::where('idtipocontratofer', '=', $unaOferta->idtipocontratofer)->pluck('tipocontratofer','idtipocontratofer');
        }else{
            $Empresa = Empresa::get(); 
            $TipoContrato = Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer');
        }
            
        return view('Obrasyfinan.Ofertas.ofeobra.editar',compact('unaOferta','Localidad','Empresa','TipoContrato', 'TipoSituacion'));
    }

    public function show($idobra)
    { 
        $idobra = base64url_decode($idobra);
        $data = Vw_ofe_obra_valida::where('idobra', $idobra)->first();
        $items = Vw_ofe_items::where('idobra', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $obra = Ofe_obra::find($idobra);
        $desembolsos = Vw_ofe_crono_desem_ant::where('idobra','=', $idobra)->orderBy('mes')->get();
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
                'id_situacion' => $request->input('idsituacion'),
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
        $desembolsos = Vw_ofe_crono_desem::where('idobra','=', $idobra)->orderBy('mes')->get();
        return view('Obrasyfinan.Ofertas.ofeobra.validar',compact('obra','data', 'cronograma', 'sombreros', 'items', 'desembolsos'));
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
            // try {
            //     Mail::to($email)->send(new AceptarOfeObra($datOfe->getEmpresa->nom_emp, $datOfe->nomobra));
            //     return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result);
            // } catch (Throwable $e) {
            //     return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result)->with('error', 'No se puedo enviar el email');
            // } 
            return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result);
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
        
        // try {
        //     Mail::to($email)->send(new RechazarOfeObra($name, $oferta, $comentario));
        //     return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.');
        // } catch (Throwable $e) {
        //     return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.')->with('error', 'No se pudo mandar el email');
        // }
        return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.');
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
        $desembolsos = vw_ofe_crono_desem_ant::where('idobra', $id)->orderBy('mes')->get();
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
        $desembolsos = vw_ofe_crono_desem_ant::where('idobra', $id)->orderBy('mes')->get();

        for ($i=0; $i <= $ofeobra->plazo; $i++) { 
            array_push($meses, $i);
        }
        array_push($meses, $ofeobra->plazo+1);
        foreach ($desembolsos as $desembolso) {
            $acu += $desembolso->costo;
            array_push($monto, str_replace(',','', number_format($acu, 2)));
        }

        $chartData = [
            "type" => "line",
            "data" => [
              "datasets" => [
                [
                  "label" => "Curva de inversiones",
                  "data" => $monto,
                  "fill" => false,
                  "borderColor" => "rgb(255, 99, 132)",
                  "lineTension" => 0.1,
                  "spanGaps" => false,
                  "pointRadius" => 3,
                  "pointHoverRadius" => 3,
                  "pointStyle" => "circle",
                  "borderDash" => [
                    0,
                    0
                  ],
                  "barPercentage" => 0.9,
                  "categoryPercentage" => 0.8,
                  "type" => "line",
                  "backgroundColor" => "rgb(255, 99, 132)33",
                  "borderWidth" => 3,
                  "hidden" => false
                ]
              ],
              "labels" => $meses,
            ],
            "options" => [
              "title" => [
                "display" => false,
                "position" => "top",
                "fontSize" => 12,
                "fontFamily" => "sans-serif",
                "fontColor" => "#666666",
                "fontStyle" => "bold",
                "padding" => 10,
                "lineHeight" => 1.2,
                "text" => "Chart title"
              ],
              "layout" => [
                "padding" => [],
                "left" => 0,
                "right" => 0,
                "top" => 0,
                "bottom" => 0
              ],
              "legend" => [
                "display" => true,
                "position" => "top",
                "align" => "center",
                "fullWidth" => true,
                "reverse" => false,
                "labels" => [
                  "fontSize" => 12,
                  "fontFamily" => "sans-serif",
                  "fontColor" => "#666666",
                  "fontStyle" => "normal",
                  "padding" => 10
                ]
              ],
              "scales" => [
                "xAxes" => [
                  [
                    "id" => "X1",
                    "position" => "bottom",
                    "display" => true,
                    "type" => "category",
                    "stacked" => false,
                    "offset" => false,
                    "time" => [
                      "unit" => false,
                      "stepSize" => 1,
                      "displayFormats" => [
                        "millisecond" => "h =>mm =>ss.SSS a",
                        "second" => "h =>mm =>ss a",
                        "minute" => "h =>mm a",
                        "hour" => "hA",
                        "day" => "MMM D",
                        "week" => "ll",
                        "month" => "MMM YYYY",
                        "quarter" => "[Q]Q - YYYY",
                        "year" => "YYYY"
                      ]
                    ],
                    "distribution" => "linear",
                    "gridLines" => [
                      "display" => true,
                      "color" => "rgba(0, 0, 0, 0.1)",
                      "borderDash" => [
                        0,
                        0
                      ],
                      "lineWidth" => 1,
                      "drawBorder" => true,
                      "drawOnChartArea" => true,
                      "drawTicks" => true,
                      "tickMarkLength" => 10,
                      "zeroLineWidth" => 1,
                      "zeroLineColor" => "rgba(0, 0, 0, 0.25)",
                      "zeroLineBorderDash" => [
                        0,
                        0
                      ]
                    ],
                    "angleLines" => [
                      "display" => true,
                      "color" => "rgba(0, 0, 0, 0.1)",
                      "borderDash" => [
                        0,
                        0
                      ],
                      "lineWidth" => 1
                    ],
                    "pointLabels" => [
                      "display" => true,
                      "fontColor" => "#666",
                      "fontSize" => 10,
                      "fontStyle" => "normal"
                    ],
                    "ticks" => [
                      "display" => true,
                      "fontSize" => 8,
                      "fontFamily" => "sans-serif",
                      "fontColor" => "#666666",
                      "fontStyle" => "normal",
                      "padding" => 0,
                      "stepSize" => null,
                      "minRotation" => 0,
                      "maxRotation" => 50,
                      "mirror" => false,
                      "reverse" => false
                    ],
                    "scaleLabel" => [
                      "display" => false,
                      "labelString" => "Axis label",
                      "lineHeight" => 1.2,
                      "fontColor" => "#666666",
                      "fontFamily" => "sans-serif",
                      "fontSize" => 12,
                      "fontStyle" => "normal",
                      "padding" => 4
                    ]
                  ]
                ],
                "yAxes" => [
                  [
                    "id" => "Y1",
                    "position" => "left",
                    "ticks" => [
                      "beginAtZero" => true,
                      "display" => true,
                      "fontSize" => 8,
                      "fontFamily" => "sans-serif",
                      "fontColor" => "#666666",
                      "fontStyle" => "normal",
                      "padding" => 0,
                      "stepSize" => null,
                      "minRotation" => 0,
                      "maxRotation" => 50,
                      "mirror" => false,
                      "reverse" => false
                    ],
                    "display" => true,
                    "type" => "linear",
                    "stacked" => false,
                    "offset" => false,
                    "time" => [
                      "unit" => false,
                      "stepSize" => 1,
                      "displayFormats" => [
                        "millisecond" => "h =>mm =>ss.SSS a",
                        "second" => "h =>mm =>ss a",
                        "minute" => "h =>mm a",
                        "hour" => "hA",
                        "day" => "MMM D",
                        "week" => "ll",
                        "month" => "MMM YYYY",
                        "quarter" => "[Q]Q - YYYY",
                        "year" => "YYYY"
                      ]
                    ],
                    "distribution" => "linear",
                    "gridLines" => [
                      "display" => true,
                      "color" => "rgba(0, 0, 0, 0.1)",
                      "borderDash" => [
                        0,
                        0
                      ],
                      "lineWidth" => 1,
                      "drawBorder" => true,
                      "drawOnChartArea" => true,
                      "drawTicks" => true,
                      "tickMarkLength" => 10,
                      "zeroLineWidth" => 1,
                      "zeroLineColor" => "rgba(0, 0, 0, 0.25)",
                      "zeroLineBorderDash" => [
                        0,
                        0
                      ]
                    ],
                    "angleLines" => [
                      "display" => true,
                      "color" => "rgba(0, 0, 0, 0.1)",
                      "borderDash" => [
                        0,
                        0
                      ],
                      "lineWidth" => 1
                    ],
                    "pointLabels" => [
                      "display" => true,
                      "fontColor" => "#666",
                      "fontSize" => 10,
                      "fontStyle" => "normal"
                    ],
                    "scaleLabel" => [
                      "display" => false,
                      "labelString" => "Axis label",
                      "lineHeight" => 1.2,
                      "fontColor" => "#666666",
                      "fontFamily" => "sans-serif",
                      "fontSize" => 12,
                      "fontStyle" => "normal",
                      "padding" => 4
                    ]
                  ]
                ]
              ],
              "plugins" => [
                "datalabels" => [
                  "display" => true,
                  "align" => "center",
                  "anchor" => "center",
                  "backgroundColor" => "#eee",
                  "borderColor" => "#ddd",
                  "borderRadius" => 6,
                  "borderWidth" => 1,
                  "padding" => 4,
                  "color" => "#666666",
                  "font" => [
                    "family" => "sans-serif",
                    "size" => 5,
                    "style" => "bold"
                  ]
                ],
                "datalabelsZAxis" => [
                  "enabled" => false
                ],
                "googleSheets" => [],
                "airtable" => [],
                "tickFormat" => ""
              ],
              "cutoutPercentage" => 50,
              "rotation" => -1.5707963267948966,
              "circumference" => 6.283185307179586,
              "startAngle" => -1.5707963267948966
            ]
            ];
        $chartData = json_encode($chartData);
        // return $chartData;
        $chartURL = "https://quickchart.io/chart?width=600&height=200&c=".urlencode($chartData);
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
                        ->stream('CurvaDeInversiones.pdf');
    } 

    public function pdfCrono($id){
        $pdf = app('dompdf.wrapper');
        $id = base64url_decode($id);
        $ofeobra = Ofe_obra::find($id);
        $desembolsos = vw_ofe_crono_desem::where('idobra', $id)->orderBy('mes')->get();
        $data = Vw_ofe_obra_valida::where('idobra', $id)->first();
        $items = Ofe_item::where('idobra', $id)->orderBy('orden')->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', $id)->get();
        // return $this->deseAcuPormes($id);
        $texto = Membrete::select('texto_1')->get();
        $texto = json_decode($texto);
        // return $items = $this->itemsConSombrero($id);
        $items = $this->itemsConSombrero($id);
        return $pdf->loadView('Obrasyfinan.Ofertas.informes.crono-pdf',[
                    'obra' => $ofeobra,
                    'data'=>$data,
                    'items'=>$items,
                    'texto'=>$texto,
                    'cronograma' => $cronograma,
                    'desembolsos' => $desembolsos,
                    ])  ->setPaper('legal', 'landscape')
                        ->stream('ItemsDeLaObra.pdf');
    }

    public function totalSombrero($idobra){
      $totalCnSom = 0;
      $totalItem = 0;
      $sombreros = Ofe_sombrero::where('idobra', $idobra)->orderBy('idconceptosombrero')->get();
      $items = Ofe_item::where('idobra', $id)->orderBy('orden')->get();

      foreach ($items as $item) {
        $totalItem += $item->costo; 
      }

      foreach ($sombreros as $unSombrero) {
          $valor += ($valor + $unSombrero->valor/100); 
      }

      $totalCnSom = $valor;
      return $totalCnSom;
    }

    public function itemsConSombrero($idobra){
        $itemsCnSom = array();
        $items = Ofe_item::where('idobra', $idobra)->orderBy('orden')->get();

        foreach ($items as $unItem) {
          $som = DB::select('SELECT iprodha.fun_ofe_porsobrero(?, ?) as mon FROM dual', [$idobra, $unItem->iditem]);
            array_push($itemsCnSom, (object)[
                                 'iditem' => $unItem->iditem,
                                 'nom_item' => $unItem->nom_item,
                                 'monto' => $som[0]->mon * $unItem->costo,
                                 'por_inc' => $unItem->por_inc,
                                 'orden' => $unItem->orden,
                          ]);
        }

        return $itemsCnSom = collect($itemsCnSom)->sortBy('orden');
    }

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


    public function verAnticipo($idobra){
        $laObra = Ofe_obra::find($idobra);
        return view('Obrasyfinan.Ofertas.anticipo.index',compact('laObra')); 
    }

    public function updateAnticipo(Request $request, $idobra){
      $idobra = base64url_decode($idobra);
      
      $this->validate($request, [
        'anticipo' => 'required|min:0|numeric|between:0,99.99',
      ], [
          'anticipo.required' => 'El valor del anticipo no puede estar vacio.',
          'anticipo.min' => 'El valor del anticipo no puede ser menor que 0.',
      ]);

      $ant = str_replace( [','], '.', $request->input('anticipo'));

      $laObra = Ofe_obra::find($idobra);

      $laObra->update([
        'anticipo' => $ant,
      ]);

      return redirect()->route('ofeobra.anticipo', $laObra->idobra)->with('mensaje','El anticipo fue modificado con exito.');
    }
}  
