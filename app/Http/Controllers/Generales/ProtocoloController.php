<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
use App\Models\rrhh\Denunciante;
use App\Models\rrhh\Denunciado;
use App\Models\rrhh\Victima;
use \PDF;



class ProtocoloController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:VER-RUBROS|CREAR-RUBROS|EDITAR-RUBROS|BORRAR-RUBROS', ['only' => ['index']]);
        // $this->middleware('permission:CREAR-RUBROS', ['only' => ['create','store']]);
        // $this->middleware('permission:EDITAR-RUBROS', ['only' => ['edit','update']]);
        //$this->middleware('permission:BORRAR-DENUNCIA', ['only' => ['destroy']]);
    }

    public function protocolo()
    {
        $pathResolucion= public_path()."\storage\pdf\\resolucion.pdf";
        $pathFormulario= public_path()."\storage\pdf\\formulario_denuncia.pdf";

        return view('Generales.protocolo', compact('pathResolucion', 'pathFormulario'));
    }

    // formularioAlta
    public function listarDenuncias(){
        try {
            $denuncias = Denuncias::with('denunciante')->orderBy('FECHA', 'desc')->get();
            //$denuncias = Denuncias::orderBy('FECHA', 'desc')->paginate(10);
        } catch (\Exception $e){
            $denuncias = 'error';
            echo "error: " . $e;
        } finally {
            return view('rrhh.denuncias.listar', compact('denuncias'));
        }
    }

    public function verDenuncia(Request $request, $id){
        $denuncia = Denuncias::find($id);
        $denunciante = Denunciante::find($id);
        $denunciado = Denunciado::find($id);
        $victima = Victima::find($id);

        return view('rrhh.denuncias.ver', compact('denuncia', 'denunciante', 'denunciado', 'victima'));
        //return view('rrhh.denuncias.ver', compact('denuncia'));
    }

    public function intervinientesDenuncia(Request $request, $id){
        $denuncia = Denuncias::find($id);
        $denunciante = Denunciante::find($id);
        $denunciado = Denunciado::find($id);
        $victima = Victima::find($id);

        return view('rrhh.denuncias.intervinientes', compact('denuncia', 'denunciante', 'denunciado', 'victima'));
    }

    public function crearDenuncia(){
        return view('rrhh.denuncias.crear');
    }

    public function guardarDenuncia(Request $request){
        $nvaDenuncia = new Denuncias;

        $nvaDenuncia->id_denuncia = Denuncias::max('ID_DENUNCIA')+1;
        $nvaDenuncia->fecha = $request->input('fecha');
        $denuncia_extracto = $request->input('denuncia_extracto');
        $nvaDenuncia->extracto = $denuncia_extracto;
        $nvaDenuncia->descripcion = $request->input('denuncia_descripcion');
        // $usuario = $request->session()->get('usuario');

        try {
            $nvaDenuncia->save();
            return redirect()->route('rrhh.denuncias.listar')->with('mensaje','Denuncia creada exitosamente.');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.listar')->back()->with('error', $e->getMessage());
        }
    }

    public function abrirModificarDenuncia(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.modificar', compact('denuncia'));
    }

    public function guardarDenunciaModificada(Request $request, $id) {
        //dd($id);
        //dd($request->all());

        // Obtener la información actual de la denuncia
        $denuncia = Denuncias::find($id);

        // Verificar si se encontró la denuncia
        if (!$denuncia) {
            return redirect()->route('rrhh.denuncias.listar')->with('error', 'Denuncia no encontrada.');
        }

        // Actualizar la información con los datos del formulario
        $denuncia->fecha = $request->input('fecha') ?? null;
        $denuncia->extracto = $request->input('denuncia_extracto');
        $denuncia->descripcion = $request->input('denuncia_descripcion');

        if ($denuncia->save()) {
            return redirect()->route('rrhh.denuncias.listar')->with('mensaje', 'Denuncia modificada exitosamente.');
        } else {
            return redirect()->route('rrhh.denuncias.listar')->with('mensaje', 'No se ha podido modificar la Denuncia.');
        }
    }


    public function destroy($id_denuncia){
        try {
            $denuncia = Denuncias::where('id_denuncia', $id_denuncia);

            if (!$denuncia){
                return redirect()->route('rrhh.denuncias.listar')->with('mensaje','No se encontró esa denuncia.');
            }

            $denuncia->delete();

            return redirect()->route('rrhh.denuncias.listar')->with('mensaje','La denuncia se borró con éxito.');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.listar')->with('error', $e->getMessage());
        }
    }

}
