<?php
namespace App\Http\Controllers\Obrasyfinan\Ofertas;

//use App\Models\Iprodha\Obras;
use App\Models\Iprodha\Ofe_obra;
use App\Models\Iprodha\Localidad;
use App\Models\Me\Expediente;
use App\Models\Iprodha\Empresa;
use App\Models\Iprodha\Ofe_tipocontratoferta;
use App\Http\Controllers\Obrasyfinan\Ofertas\ofe_obraController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ofe_obraController extends Controller
{

    function __construct()
    {
       /*this->middleware('auth');
        $this->middleware('permission:VER-OBRAS|CREAR-OBRAS|EDITAR-OBRAS|BORRAR-OBRAS', ['only' => ['index']]);
        $this->middleware('permission:CREAR-OBRAS', ['only' => ['create','store']]);
        $this->middleware('permission:EDITAR-OBRAS', ['only' => ['edit','update']]);
        $this->middleware('permission:BORRAR-OBRAS', ['only' => ['destroy']]);*/
    }
    
    public function index(Request $request)
    {        
        $Ofertas = Ofe_obra::all()->sortByDesc('nomobra');
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
        $Localidad= Localidad::pluck('nom_loc','id_loc'); 
        $Empresa= Empresa::pluck('nom_emp','id_emp'); 
        $TipoContrato= Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer'); 
        return view('Obrasyfinan.Ofertas.ofeobra.crear',compact('Localidad','Empresa','TipoContrato'));
    }

   public function store(Request $request)
    {
        //return redirect()->route('obras.index')->with('mensaje','Usuario creado con éxito!.');
        /*$validatedData = $request->validate([
            //'id_obra' => 'required|unique|integer',
            'nom_obr' => 'required|min:5|max:250|string',
            'expedte' => 'required|min:9|max:9|string',
        ]);*/
        //$show = Obras::create($validatedData);
        //crea directamente sin ID
        
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
        
        $laOferta->idtipocontratofer = $request->input('idtipocontrato');
        $laOferta->numofer = '1';

        $laOferta->aniocotizacion = date("Y", strtotime($request->input('periodo')));
        $laOferta->mescotizacion = date("m", strtotime($request->input('periodo')));

        $data = Ofe_obra::latest('idobra')->first();
        if(($data['idobra'] )=='') {
            $laOferta->idobra=    1;
        }else{
            $laOferta->idobra= $data['idobra'] +1;
        }
        
        $laOferta->save();
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$laOferta->nomobra.' fue creada.');
    }
    
    public function edit( $idobra)
    {
            $unaOferta = Ofe_obra::find(decrypt($idobra));
            $Localidad= Localidad::pluck('nom_loc','id_loc'); 
            $Empresa= Empresa::pluck('nom_emp','id_emp'); 
            $TipoContrato= Ofe_tipocontratoferta::pluck('tipocontratofer','idtipocontratofer'); 
            return view('Obrasyfinan.Ofertas.ofeobra.editar',compact('unaOferta','Localidad','Empresa','TipoContrato'));
            //return view('ofeObra.editar', ['unaOferta' => $unaOferta]);

    }
    public function show(){ 
        return redirect()->route('ofeobra.crear');
    }   

    
    public function update(Request $request,$idobra)    {   
        $this->validate($request, [
            'nomobra' => 'required|min:20|max:150|string',
            'idexpediente' => 'required|min:4|string',
            'idloc' => 'required',
            'idempresa' => 'required',
        ]);        

        $input = $request->all();
        $laOferta = Ofe_obra::find($idobra);
        
        $laOferta->nomobra = strtoupper($request->input('nomobra'));
        $laOferta->idexpediente = $request->input('idexpediente');
        $laOferta->idloc = $request->input('idloc');
        $laOferta->idempresa = $request->input('idempresa');
        /*$laOferta->moninf = $request->input('moninf');
        $laOferta->monviv = $request->input('monviv');
        $laOferta->monnex = $request->input('monnex');
        $laOferta->montotope = $request->input('montotope');*/
        $laOferta->idtipocontratofer = $request->input('idtipocontrato');
        $laOferta->numofer = '1';

        $laOferta->aniocotizacion = date("Y", strtotime($request->input('periodo')));
        $laOferta->mescotizacion = date("m", strtotime($request->input('periodo')));
        $laOferta->save();
        //return $laOferta;
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '.$request->input('nomobra').' editado con éxito!.');       
        
    }
        
    public function destroy($idobra)
    {        
        $laOferta = Ofe_obra::find($idobra);
        $laOferta->delete();
        return redirect()->route('ofeobra.index')->with('mensaje','Oferta '. $laOferta->nomobr.' borrada con éxito!.');//->with('mensaje','Oferta '. $laOferta->nomobr.' borrada con éxito!.');  
    }
}
