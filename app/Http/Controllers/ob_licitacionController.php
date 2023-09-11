<?php
    namespace App\Http\Controllers;
    use App\Models\Iprodha\ob_licitacion;
    use Illuminate\Http\Request;

    class ob_licitacionController extends Controller{        
        public function index(){
            $ob_licitacion=ob_licitacion::orderBy('año','asc')->get();      
            return view('ob_licitacion/index',compact('ob_licitacion'));
        }        
    }