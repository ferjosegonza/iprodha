<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//agregamos
use App\Models\Silverol\Fav_Favorito;


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
        
        return 4;
    }

    
    public function update(Request $request, $id)
    {
        
        return 5;
    }

    public function destroy($id)
    {     
        
        return 6;
    }

    public function guardar(Request $request, $ruta)
    {
        // var_dump($request->query->get('titulo'));
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
