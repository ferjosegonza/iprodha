<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Iprodha\Noc_Notificacion;
use App\Models\Iprodha\Noc_Mensajes;

class NotificacionController extends Controller{
    function __construct(){}

    public function store($usuario, $codigo){
        
        $noc_not = new Noc_Notificacion;
        $noc_not->idusuario = $usuario;
        $noc_not->codigo = $codigo;
        $noc_not->idnotificacion=Noc_Notificacion::find(1)->max('idnotificacion')+1;
        $noc_not->idestado=1;
        $noc_not->save();        
        return $noc_not->idnotificacion;         
    }

    public function visto($idnotificacion){
        $noc_not = Noc_Notificacion::where('idnotificacion','=',$idnotificacion)->first();
        
        if($noc_not->idestado != 2){
            $noc_not->idestado = 2;
            $noc_not->save();            
        }
        $noc_msj = Noc_Mensajes::where('codigo','=',$noc_not->codigo)->first();            
        return redirect()->route($noc_msj->ruta);                 
    }

    public function terminado($idnotificacion){
        Noc_Notificacion::where('idnotificacion','=',$idnotificacion)->update(['idestado'=>3]);
        return $noc_not->idnotificacion;         
    }

    public function verTodo($idusuario){
        $notificaciones = Noc_Notificacion::where('idusuario', '=', $idusuario)->get();
        return view('layouts.notificaciones')
        ->with('notificaciones',$notificaciones);
    }
}