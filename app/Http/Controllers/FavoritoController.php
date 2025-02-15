<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//agregamos
use App\Models\Iprodha\Fav_Favorito;


class FavoritoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-CATEGORIALABORAL|CREAR-CATEGORIALABORAL|EDITAR-CATEGORIALABORAL|BORRAR-CATEGORIALABORAL', ['only' => ['index']]);
        //  $this->middleware('permission:CREAR-CATEGORIALABORAL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-CATEGORIALABORAL', ['only' => ['edit','update']]);
        //  $this->middleware('permission:BORRAR-CATEGORIALABORAL', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {        
        return 1;
    }
    
    public function create(Request $request)
    {
       return 2;
    }

    public function store(Request $request)
    {
       $modelo = new Fav_Favorito;
       $modelo->idusuario = Auth::user()->id;
       $modelo->ruta = Route::currentRouteName();
       $modelo->save();
       return redirect()->route(Route::currentRouteName())->with('mensaje','Agregado a favorito con exito.');            
    }

    public function show($id)
    {
        return Fav_Favorito::where('idusuario', '=', Auth::user()->id)->get();
    }

   
    public function edit(Request $request, $id)
    {
        $Favorito =  Fav_Favorito::find($id);
        return view('favoritos.editar',compact('Favorito'));
    }

    
    public function update(Request $request, $id)
    { 
        $this->validate($request, [
            'titulo' => 'required|string',
            'descripcion' => 'required|string',
        ]);
        
        $Favorito =  Fav_Favorito::find($id);
        $Favorito->titulo = $request->get('titulo');
        $Favorito->descripcion = $request->get('descripcion');
        $Favorito->save();
        return redirect()->route('inicio')->with('mensaje','Favorito editado con éxito!.');
    }

    public function destroy($id)
    {
        $favorito = Fav_Favorito::find($id)->delete();
        return redirect()->route('inicio')->with('mensaje','Favorito borrado con éxito!.');     
    }

    public function guardar(Request $request, $ruta)
    {
        $favExiste[0] = null;
        $favExiste = Fav_Favorito::where('idusuario', Auth::user()->id)->where('ruta', '=', $ruta)->get();
        if(sizeof($favExiste) == 0){
            $modelo = new Fav_Favorito;
            $modelo->idusuario = Auth::user()->id;
            $modelo->ruta = $ruta;
            $modelo->titulo = $request->query->get('titulo');
            $modelo->descripcion = 'Descripcion por defecto';
            $modelo->save();
            return redirect()->route("$ruta")->with('mensaje','Agregado a favoritos con exito.');
        }else{
            Fav_Favorito::where('idusuario', Auth::user()->id)->where('ruta', '=', $ruta)->delete();
            return redirect()->route("$ruta")->with('mensaje','Quitado de favoritos con exito.');
        } 
    }

    public function allfavourites()
    {
        $Favoritos = Fav_Favorito::where('idusuario', Auth::user()->id)->get();
        return $Favoritos;
    }
}
