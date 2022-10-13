<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diegoz\Auditar;
use App\Models\MenuM;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function inicio()
    {
        return view('inicio');
    }
    
    public function phpinfo()
    {
        return view('phpinfo');
    }
    public function auditar()
    {
        $auditados = Auditar::orderBy('id', 'desc')->Paginate(50);
        return view('Coordinacion.Informatica.auditar',compact('auditados'));
            
    }
   
}
