<?php

namespace App\Http\Controllers\Obras;
use App\Http\Controllers\Controller;
use App\Models\Iprodha\ObrasCertif;
use App\Models\Iprodha\Obras;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
//use Illuminate\Support\Facades\View;

//use Spatie\Permission\Models\Permission;
//use App\Http\Controllers\Controller;
/*
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;*/

class ObrasCertifController extends Controller
{

    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:VER-DETALLEOBRAS|CREAR-OBRAS|EDITAR-OBRAS|BORRAR-OBRAS', ['only' => ['index']]);
        /*$this->middleware('permission:crear-obras', ['only' => ['create','store']]);
        $this->middleware('permission:editar-obras', ['only' => ['edit','update']]);*/
        $this->middleware('permission:VER-DETALLEOBRAS', ['only' => ['view']]);
        /*$this->middleware('permission:borrar-obras', ['only' => ['destroy']]);*/
    }
    public function detalle($id_obra){
        //return $id_obra;
        $certificados = Obras::find($id_obra)->certificados;
        return view('obras.verDetalles', ['certificados' => $certificados]);
        
    }    
    
}
