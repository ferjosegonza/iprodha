<?php
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Models\Iprodha\ob_licitacion;
    use App\Models\Iprodha\ob_tipo_licitacion;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Validator;
    use Illuminate\Support\Facades\DB;

    class ob_licitacionController extends Controller{
        public function index(){            
            $ob_licitacion=ob_licitacion::with('ob_tipo_licitacion')
            ->join('iprodha.ob_tipo_licitacion',function($join){
                $join->on('ob_licitacion.id_tipo','=','ob_tipo_licitacion.id_tipolic');
            })
            ->orderBy('año','asc')
            ->get();
            return view('ob_licitacion/index',compact('ob_licitacion'));
        }        
    }