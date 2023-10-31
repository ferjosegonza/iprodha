<?php
namespace App\Http\Controllers\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Iprodha\App_usuario;
use App\Models\Iprodha\App_not_tipo;
use App\Models\Iprodha\App_not_x_usuario;
use App\Models\Iprodha\App_not_boletadisponible;
use DB;

class AppNotificacionesController extends Controller
{
    public function notificacionBoletas(){
        $tipos_not = App_not_tipo::where('forma', '=', 1)->get();
        return view('app.boletas')
        ->with('tipos_not', $tipos_not);
    }

    public function pendientes(){
        $pendientes = App_not_boletadisponible::orderBy('fecha')->get();
        return response()->json($pendientes);
    }
    
    public function enviarBoletas(){
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $pendientes = App_not_boletadisponible::get();
        $res = 1;
        foreach($pendientes as $p){
            $user = App_usuario::where('usuario', '=', $p->usuario)->first();
            $response = Http::post('https://app.nativenotify.com/api/indie/notification', [
                'subID' => '\'' . $user->id . '\'',
                'appId' => 13251,
                'appToken' => 'oKxfawQe7CdbWGkFd9zDrC',
                'title' => $p->encabezado,
                'message' => $p->mensaje
            ]);
            if($response){
                $noti = new App_not_x_usuario;
                $noti->usuario = $p->usuario;
                $noti->fecha = date("Y-m-d h:i:s");
                $noti->id_tipo = $p->tipo;
                $noti->encabezado = $p->encabezado;
                $noti->mensaje = $p->mensaje;
                $res *= $noti->save();
            }
        }
        return response()->json($res);
    }
}