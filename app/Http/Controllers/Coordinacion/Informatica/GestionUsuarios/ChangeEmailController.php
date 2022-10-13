<?php
   
namespace App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios;
use App\Http\Controllers\Controller;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
  
class ChangeEmailController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    
    public function store(Request $request)
    {
        $user = User::Fail(auth()->user()->id);
        
        /*
        Validate all input fields
        */

        if (!Hash::check($request->contraseña, $user->password)) { 
            return redirect()->route('inicio')->with('error','Contraseña Invalida.');
        }

        if (strcmp($user->email, $request->input('email')) === 0) {

            $request->validate([
                'nombre' => 'required|string|max:191'
            ]);
            if ($user->fill(['name' => strtoupper($request->nombre)])->save()) { 
                return redirect()->route('inicio')->with('mensaje','Nombre editado con Exito.');
            
            } else {
                return redirect()->route('inicio')->with('error','Error al Guardar.');
            }

        }else{
            $request->validate([
                'nombre' => 'required|string|max:191',
                'email' => 'required|string|email|max:191|unique:users'
            ]);
            
            if ($user->fill(['email' => $request->email,'name' => strtoupper($request->nombre)])->save()) { 
                return redirect()->route('inicio')->with('mensaje','Editado con Exito.');
            
            } else {
                return redirect()->route('inicio')->with('error','Error al Guardar.');
            }
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