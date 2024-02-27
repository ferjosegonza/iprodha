<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
use app\Models\rrhh\Denunciante;
use \PDF;



class DenuncianteController extends Controller
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

    /*
    // ESTE NO VOY A USAR
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
    } */

    public function verDenunciante(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.denunciante.ver', compact('denunciante'));
    }

    // dejar esta función para q, desde el formulario de denunciante se puede volver a la vista de la denuncia q permite gestionar los intervinientes
    public function intervinientesDenuncia(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.intervinientes', compact('denuncia'));
    }

    public function crearDenunciante(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.denunciante.crear', compact('denuncia'));
    }

    public function guardarDenunciante(Request $request){
        /*
        - todos los campos de la BD:
            ID_DENUNCIA
            NRO_DOC
            APELLIDO
            NOMBRE
            TIPO_DOC
            ID_SEXO
            FECHA_NAC
            DOMICILIO
            MAIL
            TELEFONO
            VINCULO_INST
            ES_VICTIMA

        - todos los campos del form guardar:
            id_denuncia
            denunciante_victima
            apellido_denunciante
            nombres_denunciante
            tipo-doc
            num-doc
            tipo-sex
            fecha-nac
            direccion
            email
            tel
            tipo-vinculo
        */
        $nvaDenunciante = new Denunciante;

        //$nvaDenunciante->id_denuncia = Denunciante::max('ID_DENUNCIA')+1;
        $nvaDenunciante->id_denuncia = $request->input('id_denuncia');

        $nvaDenunciante->fecha = $request->input('fecha');
        $denuncia_extracto = $request->input('denuncia_extracto');
        $nvaDenunciante->extracto = $denuncia_extracto;
        $nvaDenunciante->descripcion = $request->input('denuncia_descripcion');
        // $usuario = $request->session()->get('usuario');

        try {
            $nvaDenunciante->save();
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
