<?php
namespace App\Http\Controllers\Construcciones\Certificacion;

use App\Models\Iprodha\vw_ofe_obras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class vw_ofe_obrasController extends Controller
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
        $nomobra = $request->query->get('name');
        
        return vw_ofe_obras::filtronombre($nomobra)->orderBy('nomobra', 'asc')->get();

        /*$nomobra = $request->query->get('name');
        if (!isset($nomobra)) { 
            $Ofertas = vw_ofe_obras::orderBy('nomobra', 'asc')->paginate(5);
            return view('ofeObra.index',compact('Ofertas'));
        } else {
            $Ofertas = vw_ofe_obras::where('nomobra', 'like', '%' .  strtoupper($nomobra) . '%')->orderBy('nomobra', 'DESC')->paginate(5);
            return view('ofeObra.index',compact('Ofertas'));
        }*/
       
    }    
}
