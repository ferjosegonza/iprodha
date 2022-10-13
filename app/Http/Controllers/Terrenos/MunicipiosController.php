<?php
namespace App\Http\Controllers\Terrenos;

use Illuminate\Http\Request;
use App\Models\Iprodha\Municipios;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class MunicipiosController extends Controller
{
    public function index()
    {
        $municipios = Muncipios::all(); 
    }

    

}
