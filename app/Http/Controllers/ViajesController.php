<?php
namespace App\Http\Controllers; 

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ViajesController extends Controller
{
    public function index()
    {
        return 'Hola Mundo desde el Controlador';
      //return view('viajes.viajes');
        
    }
    
}