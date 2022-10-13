<?php

namespace App\Http\Controllers;

use App\Models\Iprodha\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
         $this->middleware('permission:VER-ALUMNOS|CREAR-ALUMNOS|EDITAR-ALUMNOS|BORRAR-ALUMNOS', ['only' => ['index']]);
         $this->middleware('permission:CREAR-ALUMNOS', ['only' => ['create','store']]);
         $this->middleware('permission:EDITAR-ALUMNOS', ['only' => ['edit','update']]);
         $this->middleware('permission:BORRAR-ALUMNOS', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
        
        $nombre = $request->query->get('nombre');

        $alumnos = Alumno::nombre($nombre)->get();

        return view('alumnos.index',compact('alumnos'));
    }

    
    public function create()
    {
        return view('alumnos.crear');
    }

    
    public function store(Request $request)
    {

        $this->validate($request, [
            'dni' => 'required|numeric|max:99999999|min:10000000|unique:oracle.iprodha.alumno,dni',
            'nombre' => 'required|alpha',
            'cuil' => 'required|numeric|max:99999999999|min:10000000|unique:oracle.iprodha.alumno,cuil',
            'fechanac' => 'required|date'
        ]);
    


        $alumno = new Alumno;

        $alumno->dni = $request->input('dni');
        $alumno->nombre = $request->input('nombre');
        $alumno->cuil = $request->input('cuil');
        $alumno->fechanac = $request->input('fechanac');

        $alumno->save();

        return redirect()->route('alumnos.index')->with('mensaje','Alumno '.$alumno->nombre.' creado con éxito!.');        
    }

    
    public function show(Alumno $alumno)
    {
        //
    }

    
    public function edit(Request $request, $dni)
    {
        $alumno = Alumno::find($dni);
        return view('alumnos.editar',compact('alumno'));
    }

    
    public function update(Request $request, $dni)
    {
        $this->validate($request, [
            'nombre' => 'required|alpha',
            'cuil' => 'required|numeric|max:99999999999|min:10000000',
            'fechanac' => 'required|date'
        ]);
    

        $alumno = Alumno::find($dni);

        $alumno->nombre = $request->input('nombre');
        $alumno->cuil = $request->input('cuil');
        $alumno->fechanac = $request->input('fechanac');

        $alumno->save();

        return redirect()->route('alumnos.index')->with('mensaje','Alumno '.$alumno->nombre.' editado con éxito!.');        
    }

    
    public function destroy($dni)
    {
        Alumno::find($dni)->delete();
        return redirect()->route('alumnos.index')->with('mensaje','Alumno borrado exitosamente.');
    }
}
