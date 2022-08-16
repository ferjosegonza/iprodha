<?php
   
namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;
use App\Http\Controllers\Controller;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
  
class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
   
    
    public function store(Request $request)
    {
        $token = $request->session()->token();
        $token = csrf_token();

        $user = User::findOrFail(auth()->user()->id);
        
        /*
        Validate all input fields
        */
        
        
        $this->validate($request, [
            'contraseña_actual' => 'required',
            'contraseña' => 'required|min:8|different:contraseña_actual',
            'contraseña_confirmacion'=>'same:contraseña'
        ]);

        
        
        if (Hash::check($request->contraseña_actual, $user->password)) { 
           $user->fill(['password' => Hash::make($request->contraseña)])->save();
        
            $request->session()->flash('success', 'Password changed');
            auth()->logout();
            return redirect()->route('inicio')->with('mensaje','Contraseña editada con Exito.');
        
        } else {
            $request->session()->flash('error', 'Password does not match');
            return redirect()->route('inicio')->with('error','Contraseña actual Incorrecta.');
        }

    }


    public function index(Request $request)
    {
    }

    public function create()
    {
    }

    
    public function show($id)
    {
    }

    
    public function edit(Request $request)
    {
    }
    

    public function update(Request $request)
    {
    }

    public function destroy()
    {
    }


}