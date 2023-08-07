<?php

namespace App\Http\Controllers\Coordinacion\Notarial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TramiteController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');  
    }

    
}