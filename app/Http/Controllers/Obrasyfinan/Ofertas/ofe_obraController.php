<?php
namespace App\Http\Controllers\Obrasyfinan\Ofertas;

//use App\Models\Iprodha\Obras;

use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Localidad;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Ofe_tipocontratoferta;
use App\Models\Iprodha\Ofe_estadoxobra;
use App\Models\Iprodha\Ofe_obraestado;
use App\Models\Iprodha\Ofe_sombrero;
use App\Models\Iprodha\Ofe_subitem;
use App\Models\Iprodha\Vw_ofe_obra_valida;
use App\Models\Iprodha\Vw_ofe_items;
use App\Models\Iprodha\Vw_ofe_cronograma;
use App\Http\Controllers\Obrasyfinan\Ofertas\ofe_obraController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \PDF;
use iio\libmergepdf\Merger;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;


class ofe_obraController extends Controller
{

    function __construct()
    {
        /*$this->middleware('auth');
        $this->middleware('permission:VER-OBRAS|CREAR-OBRAS|EDITAR-OBRAS|BORRAR-OBRAS', ['only' => ['index']]);
        $this->middleware('permission:CREAR-OBRAS', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-OBRAS', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-OBRAS', ['only' => ['destroy']]);*/
    }
    
    public function index(Request $request)
    {        
        /*if(Auth::user()->hasRole('EMPRESA')){
            $editaTodo=false;
        }else{
            $editaTodo=true ;
        }
    */
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
        $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc'); 
        $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp'); 
        $TipoContrato= Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer'); 
        return view('Obrasyfinan.Ofertas.ofeobra.crear',compact('Localidad','Empresa','TipoContrato'));
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
        ]);              
        
        $input = $request->all();
        $laOferta = new Ofe_obra;
        $laOferta->nomobra = strtoupper($request->input('nomobra'));
        $laOferta->idexpediente = $request->input('idexpediente');
        $laOferta->idloc = $request->input('idloc');
        $laOferta->idempresa = $request->input('idempresa');
        $laOferta->moninf = $request->input('moninf');
        $laOferta->monviv = $request->input('monviv');
        $laOferta->monnex = $request->input('monnex');
        $laOferta->montotope = $request->input('montotope');
        $laOferta->plazo = $request->input('plazo');
        $laOferta->publica = $request->input('publica');
        $laOferta->idtipocontratofer = $request->input('idtipocontrato');
        $laOferta->numofer = '1';

        $laOferta->aniocotizacion = date("Y", strtotime($request->input('anioymes')));
        $laOferta->mescotizacion = date("m", strtotime($request->input('anioymes')));

        $data = Ofe_obra::latest('idobra')->first();
        if (isset($data)){
            if(($data['idobra'] )=='') {
                $laOferta->idobra=    1;
            }else{
                $laOferta->idobra= $data['idobra'] +1;
            }
        }else{

            $laOferta->idobra= 1;
        }
        // return $laOferta->idobra;
        // Ofe_estadoxobra::create(['idobra' => $laOferta->idobra, 'idestado' => 1, 'fechacambio' => 0]);
        // $estado = new Ofe_estadoxobra;
        // return $estado;
        // $estado->idobra = $laOferta->idobra;
        // $estado->idestado = '1';
        
        $laOferta->save();
        Ofe_estadoxobra::create(['idobra' => $laOferta->idobra, 'idestado' => 1]);
        // $estado->save();
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.');
    }
    
    public function edit( $idobra)
    {
            
            $unaOferta = Ofe_obra::find(decrypt($idobra));
            $Localidad= Localidad::pluck('nom_loc','id_loc');
            // return $unaOferta->getTipoOferta;
            if(Auth::user()->hasRole('EMPRESA')){
                $Empresa = Empresa::where('iduserweb','=',Auth::user()->id)->pluck('nom_emp', 'id_emp');
                $TipoContrato = Ofe_tipocontratoferta::where('idtipocontratofer', '=', $unaOferta->idtipocontratofer)->pluck('tipocontratofer','idtipocontratofer');
            }else{
                $Empresa = Empresa::pluck('nom_emp','id_emp'); 
                $TipoContrato = Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer');
            }
             
            return view('Obrasyfinan.Ofertas.ofeobra.editar',compact('unaOferta','Localidad','Empresa','TipoContrato'));
            //return view('ofeObra.editar', ['unaOferta' => $unaOferta]);

    }
    public function show(){ 
        return redirect()->route('ofeobra.crear');
    }   

    
    public function update(Request $request,$idobra)
    {   
        // return $request->input();
        // return date("m", strtotime($request->input('aymcot')));
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
        $input = $request->all();
        $laOferta = Ofe_obra::find(decrypt($idobra));
        
        $laOferta->nomobra = strtoupper($request->input('nomobra'));
        $laOferta->idexpediente = $request->input('idexpediente');
        $laOferta->idloc = $request->input('idloc');
        $laOferta->idempresa = $request->input('idempresa');
        $laOferta->plazo = $request->input('plazo');
        $laOferta->idtipocontratofer = $request->input('idtipocontrato');
        $laOferta->numofer = '1';
        $laOferta->publica = $request->input('publica');
        $laOferta->aniocotizacion = date("Y", strtotime($request->input('anioymes')));
        $laOferta->mescotizacion = date("m", strtotime($request->input('anioymes')));
        $laOferta->save();
        //return $laOferta;
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$request->input('nomobra').' editado con éxito!.');       
        
    }
        
    public function destroy($idobra)
    {        
        Ofe_estadoxobra::where('idobra', '=', $idobra)->delete();
        $laOferta = Ofe_obra::find($idobra);
        $laOferta->delete();
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '. $laOferta->nomobr.' borrada con éxito!.');//->with('mensaje','Oferta '. $laOferta->nomobr.' borrada con éxito!.');  
    }    

    public function presentarOferta($idobra)
    {
        //Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 2]);  
        //return $idobra;
        $data = Vw_ofe_obra_valida::where('idobra', '=', decrypt($idobra))->first();
        $items = Vw_ofe_items::where('idobra', '=', decrypt($idobra))->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', decrypt($idobra))->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', decrypt($idobra))->get();
        // return $cronograma->where('iditem', 4)->all();
        // return is_null($cronograma->where('iditem', 6)->where('mes', 1)->first());
        $obra=Ofe_obra::where('idobra','=',decrypt($idobra))->first();
              
        //return $tipoContrato;

        // return $sombreros->where('idconceptosombrero', 10)->first()->valor;
        return view('Obrasyfinan.Ofertas.ofeobra.presentar')
        ->with('data',$data)
        ->with('items',$items)
        ->with('cronograma',$cronograma)
        ->with('obra', $obra)
        ->with('sombreros',$sombreros);
    }

    public function presentarSave($idobra){
        //  return decrypt($idobra);
        Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 2]);
        return redirect()->route('ofeobra.index')->with('mensaje','Se presentó la oferta de obra con exito.');
    }

    public function verValidarOferta($idobra){
        $data = Vw_ofe_obra_valida::where('idobra', '=', decrypt($idobra))->first();
        $obra = Ofe_obra::where('idobra','=',decrypt($idobra))->first();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', decrypt($idobra))->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', decrypt($idobra))->get();
        $items = Vw_ofe_items::where('idobra', '=', decrypt($idobra))->get();
        // return $obra->getItems;
        return view('Obrasyfinan.Ofertas.ofeobra.validar',compact('obra','data', 'cronograma', 'sombreros', 'items'));
        // return "Entro en verValidarOferta con id en ".decrypt($idobra);
    }

    public function validarOferta($idobra)
    {
        // return 'Cuidado al ingresar aca';
        Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 3]);
        
        $result = null;
        $procedureName = 'iprodha.SP_OFE_MIGRAOBRA';
        $bindings = [
            'idobra'  => decrypt($idobra),
            'result' => [
                'value' => &$result,
                'length' => 1000,
            ],
        ];
        // return $idobra;
        $succeeded = DB::executeProcedure($procedureName, $bindings);

        if($succeeded) {
            // return ($result);
            return redirect()->route('ofeobra.vervalidar', $idobra)->with('alerta', $result);
        }
        else {
            // return ("Failed");
            return redirect()->route('ofeobra.vervalidar', $idobra)->with('error','Problemas con el procedimiento.');
        }
    }

    public function rechazarOferta(Request $request, $idobra)
    {
        $comentario = $request->input('comentario');
        $name = $request->input('nom_emp');
        $oferta = $request->input('nombobra');
        $subject = "Asunto del correo";
        $for = "lisandrosilvero@gmail.com";
        Mail::to($for)->send(new OrderShipped($name, $oferta, $comentario));
        // Mail::send('Obrasyfinan.Ofertas.mail.rechazar',$request->all(), function($msj) use($subject,$for){
        //     $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
        //     $msj->subject($subject);
        //     $msj->to($for);
        // });
        // return $request;
        Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 4]);
        Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 1]);
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


    public function pdfnoo($idobra){
        //datos
        $obra = Ofe_Obra::where('idobra', '=', $idobra)->first(); 
        $vw=Vw_ofe_items::where('idobra', '=', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $data = Vw_ofe_obra_valida::where('idobra', '=', $idobra)->first();
        $texto = DB::table('iprodha.membrete')
                    ->select('texto_1')
                    ->get();  
        $texto = json_decode($texto);

        //merger
        $merger = new Merger;
        
        //pdf1
        $dompdf = app('dompdf.wrapper');
        $dompdf->loadView('Obrasyfinan.Ofertas.ofeobra.pdf2',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto])
                    ->setPaper('a4', 'portrait');
        $dompdf->render();
        $merger->addRaw($dompdf->output());
        unset($dompdf);



        $dompdf = app('dompdf.wrapper');
        $dompdf->set_paper('letter', 'landscape');
        $dompdf->loadView('Obrasyfinan.Ofertas.ofeobra.pdf1',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto]);
        $merger->addRaw($dompdf->output());
        $dompdf->render();

        file_put_contents('\SysLaravel\public\pdf\combined.pdf', $merger->merge());

        
    }

    public function pdf($idobra){
        $pdf1 = app('dompdf.wrapper');
        $pdf2 = app('dompdf.wrapper');
        $obra = Ofe_Obra::where('idobra', '=', $idobra)->first(); 
        $vw=Vw_ofe_items::where('idobra', '=', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $data = Vw_ofe_obra_valida::where('idobra', '=', $idobra)->first();
        $texto = DB::table('iprodha.membrete')
                    ->select('texto_1')
                    ->get();  
        $texto = json_decode($texto);

        $pdf1->loadView('Obrasyfinan.Ofertas.ofeobra.pdf2',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto])
                                    ->setPaper('a4', 'portrait')
                                    ->render();
                                    //->stream('obraPresentada.pdf');
        $pdf2->loadView('Obrasyfinan.Ofertas.ofeobra.pdf1',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma, 'texto'=>$texto])
                                    ->setPaper('a4', 'landscape')
                                    ->render();
                                    //->stream('obraPresentada.pdf');

        /* $filename2='pdf_2_'.$idobra; 
        $filename1='pdf_1_'.$idobra; */       
        $path2='\SysLaravel\public\pdf\pdf_2_'.$idobra.'pdf'; 
        $path1='\SysLaravel\public\pdf\pdf_1_'.$idobra.'pdf';
        //$content1 = $pdf1->download()->getOriginalContent();
        //$content2 = $pdf2->download()->getOriginalContent();

        file_put_contents($path1, $pdf1); 
        file_put_contents($path2, $pdf2); 

        //$pdf1->save($path1);
        //$pdf2->save($path2);         
        return utf8_decode($pdf1->output());
       /*  $content1 = $pdf1->output();
        Storage::put($path1.'.pdf',$pdf1);
        $content2 = $pdf2->output();
        Storage::put($path2.'.pdf',$pdf2);  */
        
        $merger = new Merger;
        $merger->addFile('\SysLaravel\public\pdf\pdf_1_'.$idobra.'.pdf');
        $merger->addFile('\SysLaravel\public\pdf\pdf_2_'.$idobra.'.pdf');

        
        $createdPdf = $merger->merge();
        return $createdPdf;
    }

    public function pdfNo($idobra) //no funciona
    {
        // alternativamente con:
        $pdf = app('dompdf.wrapper');
        
        $obra = Ofe_Obra::where('idobra', '=', $idobra)->first(); 
        $vw=Vw_ofe_items::where('idobra', '=', $idobra)->get();
        $cronograma = Vw_ofe_cronograma::where('idobra', '=', $idobra)->orderBy('mes')->get();
        $sombreros = Ofe_sombrero::where('idobra', '=', $idobra)->get();
        $data = Vw_ofe_obra_valida::where('idobra', '=', $idobra)->first();
        
        $path1='SysLaravel\resources\pdf\pdf_1_'.$idobra.'.pdf';      
        $pdf1 = Pdf::loadView('Obrasyfinan.Ofertas.ofeobra.pdf1',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma])->setPaper('a4', 'landscape');
        $path2='SysLaravel\resources\pdf\pdf_2_'.$idobra.'.pdf';      
        $pdf2 = Pdf::loadView('Obrasyfinan.Ofertas.ofeobra.pdf2',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma])->setPaper('a4', 'portrait');
       /*  $dom_pdf1 = $pdf1->getDomPDF();
        $canvas1 = $dom_pdf1->get_canvas();
        $dom_pdf2 = $pdf2->getDomPDF();
        $canvas2 = $dom_pdf2->get_canvas(); */
       /*  Storage::disk('local')->put($path1, $pdf1->output());
        Storage::disk('local')->put($path2, $pdf2->output()); */



        $merger = new Merger(new TcpdiDriver);
        $merger->addFile('pdf_2_'.$idobra.'.pdf');
        $merger->addFile('pdf_2_'.$idobra.'.pdf');
        $createdPdf = $merger->merge();
        return $createdPdf;
        //return $pdf1;        
        //return $pdf->loadView('Obrasyfinan.Ofertas.ofeobra.pdf1',['obra'=>$obra, 'vw'=>$vw, 'data'=>$data, 'sombreros'=>$sombreros, 'cronograma'=>$cronograma])
                                    //->setPaper('a4', 'landscape')
                                    //->stream('obraPresentada.pdf');
        
        //return $pdf1->download($path1);
        /* $pdf1->render();
        $output = $pdf1->output();
        file_put_contents($path1, $output); */
    }
}  
