<?php

namespace App\Http\Controllers\Coordinacion\Notarial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Iprodha\Not_tramite;
use App\Models\Iprodha\Not_tramite_tipo;
use App\Models\Iprodha\Not_profesional;
use App\Models\Iprodha\Not_profesional_caracter;

class NotarialController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    public function bandeja(){      
        return view('Coordinacion.Notarial.bandeja');       
    }

    public function alta_tramite(){      
        $tipos = Not_tramite_tipo::get();
        $profesional = Not_profesional::get();
        $caracter = Not_profesional_caracter::get();
        return view('Coordinacion.Notarial.alta_tramite')
        ->with('tipos', $tipos)
        ->with('profesional', $profesional)
        ->with('caracter', $caracter);       
    }
}