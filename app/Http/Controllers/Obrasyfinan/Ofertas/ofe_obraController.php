<?php
namespace App\Http\Controllers\Obrasyfinan\Ofertas;

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
use App\Mail\Obrasyfinan\Ofertas\RechazarOfeObra;
use App\Mail\Obrasyfinan\Ofertas\AceptarOfeObra;
use App\Mail\Obrasyfinan\Ofertas\CrearOfeObra;


class ofe_obraController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-OFEOBRA|CREAR-OFEOBRA|EDITAR-OFEOBRA|BORRAR-OFEOBRA', ['only' => ['index']]);
        // $this->middleware('permission:CREAR-OFEOBRA', ['only' => ['create','store']]);
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
        $Localidad= Localidad::orderBy('nom_loc')->pluck('nom_loc','id_loc');

        // if(Auth::user()->hasRole('EMPRESA')){
        //     $Empresa= Empresa::where('iduserweb' ,Auth::user()->id)->orderBy('nom_emp')->pluck('nom_emp','id_emp');
        // }else{
        //     $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        // }
        // $Empresa= Empresa::orderBy('nom_emp')->pluck('nom_emp','id_emp');
        $Empresa= Empresa::orderBy('nom_emp')->get();
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

    public function show()
    { 
        return redirect()->route('ofeobra.crear');
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
        //Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 3]);
        $datOfe = Ofe_obra::where('idobra', decrypt($idobra))->first();
        $email = strval(Empresa::where('id_emp', $datOfe->idempresa)->first()->email);
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
        $comentario = $request->input('comentario');
        $name = $request->input('nom_emp');
        $oferta = $request->input('nombobra');
        $subject = "Asunto del correo";
        $datOfe = Ofe_obra::where('idobra', decrypt($idobra))->first();
        $email = Empresa::where('id_emp', $datOfe->idempresa)->first()->email;

        

        try {
            Mail::to($email)->send(new RechazarOfeObra($name, $oferta, $comentario));
            Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 4]);
            Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 1]);
            return redirect()->route('ofeobra.index')->with('mensaje','Se rechazo la oferta de obra con exito.');
        } catch (Throwable $e) {
            Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 4]);
            Ofe_estadoxobra::create(['idobra' => decrypt($idobra), 'idestado' => 1]);
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

}  
