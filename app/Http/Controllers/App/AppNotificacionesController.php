<?php
namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_usuario;

class AppNotificacionesController extends Controller
{
    public function notificacionBoletas(){
        return view('app.boletas');
    }
}