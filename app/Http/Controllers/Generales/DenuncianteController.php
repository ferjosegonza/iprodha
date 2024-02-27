<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
use App\Models\rrhh\Denunciante;
//use \PDF;
use DateTime;


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

    public function verDenunciante(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.denunciante.ver', compact('denunciante'));
    }

    // dejar esta función para q, desde el formulario de denunciante se puede volver a la vista de la denuncia q permite gestionar los intervinientes
    // public function intervinientesDenuncia(Request $request, $id){
    //     $denuncia = Denuncias::find($id);
    //     return view('rrhh.denuncias.intervinientes', compact('denuncia'));
    // }

    public function crearDenunciante(Request $request, $id){
        $denuncia = Denuncias::find($id);
        return view('rrhh.denuncias.denunciante.crear', compact('denuncia'));
    }

    public function guardarDenunciante(Request $request){
        /*echo 'id_denuncia'.$request->input('id_denuncia');
        echo 'num-doc'.$request->input('num-doc');
        echo 'apellido_denunciante'.$request->input('apellido_denunciante');
        echo 'nombres_denunciante'.$request->input('nombres_denunciante');
        echo 'tipo-doc'.$request->input('tipo-doc');
        echo 'tipo-sex'.$request->input('tipo-sex');
        echo 'fecha-nac'.$request->input('fecha-nac');
        echo 'direccion'.$request->input('direccion');
        echo 'email'.$request->input('email');
        echo 'tel'.$request->input('tel');
        echo 'tipo-vinculo'.$request->input('tipo-vinculo');
        $esVictima = isset($_POST['denunciante_victima']) ? 1 : 0 ;
        echo 'esVictima'.$esVictima;*/

        /*
        campos de la BD:    campos del form guardar:
            ID_DENUNCIA     id_denuncia
            NRO_DOC         num-doc
            APELLIDO        apellido_denunciante
            NOMBRE          nombres_denunciante
            TIPO_DOC        tipo-doc
            ID_SEXO         tipo-sex
            FECHA_NAC       fecha-nac
            DOMICILIO       direccion
            MAIL            email
            TELEFONO        tel
            VINCULO_INST    tipo-vinculo
            ES_VICTIMA      denunciante_victima
        */
        $nvaDenunciante = new Denunciante;
        $id_denuncia = $request->input('id_denuncia');

        //$nvaDenunciante->id_denuncia = Denunciante::max('ID_DENUNCIA')+1;
        $nvaDenunciante->id_denuncia = $id_denuncia;
        $nvaDenunciante->nro_doc = $request->input('num-doc');
        $nvaDenunciante->apellido = "\"".$request->input('apellido_denunciante')."\"";
        $nvaDenunciante->nombre = "\"".$request->input('nombres_denunciante')."\"";
        $nvaDenunciante->tipo_doc = $request->input('tipo-doc');
        $nvaDenunciante->id_sexo = $request->input('tipo-sex');
        $fechaOriginal = $request->input('fecha-nac');
        //$fechaFormateada = DateTime::createFromFormat('Y-m-d', $fechaOriginal)->format('d-m-Y');
        //echo $fechaFormateada;
        //$nvaDenunciante->fecha_nac = "\"".$request->input('fecha-nac')."\"";
        $nvaDenunciante->fecha_nac = "'".$fechaOriginal."'";
        $nvaDenunciante->domicilio = "\"".$request->input('direccion')."\"";
        $nvaDenunciante->mail = "\"".$request->input('email')."\"";
        $nvaDenunciante->telefono = "\"".$request->input('tel')."\"";
        $nvaDenunciante->vinculo_inst = $request->input('tipo-vinculo');
        $esVictima = isset($_POST['denunciante_victima']) ? 1 : 0 ;
        $nvaDenunciante->es_victima = $esVictima;
        //echo $nvaDenunciante;
        // $usuario = $request->session()->get('usuario');

        try {
            $nvaDenunciante->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with(['message'=> 'Se ha agregado el Denunciante']);
        } catch (\Exception $e){
            //return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->back()->with('error', $e->getMessage());
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
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
