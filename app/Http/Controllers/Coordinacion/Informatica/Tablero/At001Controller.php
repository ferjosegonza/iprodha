<?php

namespace App\Http\Controllers\Coordinacion\Informatica\Tablero;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Iprodha\Vw_tc_at001_cancelaciones;




class At001Controller extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        //  $this->middleware('permission:VER-ROL|CREAR-ROL|EDITAR-ROL|BORRAR-ROL', ['only' => ['index','buscarvista']]);
        //  $this->middleware('permission:CREAR-ROL', ['only' => ['create','store']]);
        //  $this->middleware('permission:EDITAR-ROL', ['only' => ['edit','update','updatevista']]);
        //  $this->middleware('permission:BORRAR-ROL', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {        
    }
    


    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {              
    }
    
    public function cancelaciones(){
        $data = Vw_tc_at001_cancelaciones::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

}