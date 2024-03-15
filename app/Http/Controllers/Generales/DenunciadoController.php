<?php
//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
// use App\Models\rrhh\Denunciante;
use App\Models\rrhh\Denunciado;
// use App\Models\rrhh\Victima;
use App\Models\rrhh\Sexo;
use App\Models\rrhh\Tipdoc;
use App\Models\rrhh\Vinculo;
// use DateTime;
//use \PDF;

class DenunciadoController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('permission:VER-RUBROS|CREAR-RUBROS|EDITAR-RUBROS|BORRAR-RUBROS', ['only' => ['index']]);
        // $this->middleware('permission:CREAR-RUBROS', ['only' => ['create','store']]);
        // $this->middleware('permission:EDITAR-RUBROS', ['only' => ['edit','update']]);
        //$this->middleware('permission:BORRAR-DENUNCIA', ['only' => ['destroy']]);
    }

    // public function verDenunciante(Request $request, $id){
    //     $denuncia = Denuncias::find($id);
    //     return view('rrhh.denuncias.denunciante.ver', compact('denunciante'));
    // }

    // dejar esta función para q, desde el formulario de denunciante se puede volver a la vista de la denuncia q permite gestionar los intervinientes
    // public function intervinientesDenuncia(Request $request, $id){
    //     $denuncia = Denuncias::find($id);
    //     return view('rrhh.denuncias.intervinientes', compact('denuncia'));
    // }

    public function crearDenunciado(Request $request, $id){
        $denuncia = Denuncias::find($id);
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.denunciado.crear', compact('denuncia', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarDenunciado(Request $request){
        $nvaDenunciado = new Denunciado;

            $id_denuncia = $request->input('id_denuncia');
            $nvaDenunciado->id_denuncia = $id_denuncia;
            $nvaDenunciado->nro_doc = $request->input('num-doc');
            $nvaDenunciado->apellido = strlen($request->input('apellido_denunciado')) == 0 ? NULL : strtoupper($request->input('apellido_denunciado'));
            $nvaDenunciado->nombre = strlen($request->input('nombres_denunciado')) == 0 ? NULL : strtoupper($request->input('nombres_denunciado'));
            $nvaDenunciado->tipo_doc = $request->input('tipo-doc');
            $nvaDenunciado->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
            $nvaDenunciado->fecha_nac = $request->input('fecha-nac');
            $nvaDenunciado->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
            $nvaDenunciado->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
            $nvaDenunciado->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
            $nvaDenunciado->vinculo_inst = $request->input('tipo-vinculo');
            $nvaDenunciado->vinculo_vict = strlen($request->input('vinculo-victima')) == 0 ? NULL : strtoupper($request->input('vinculo-victima'));
            //$nvaDenunciado->vinculo_vict = $request->input('vinculo-victima');

        try {
            $nvaDenunciado->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', 'Se ha agregado los datos de la Víctima');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

    public function abrirModificarDenunciado(Request $request, $id){
        $denunciado = Denunciado::find($id);
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.denunciado.modificar', compact('denunciado', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarDenunciadoModificado(Request $request, $id) {
        //dd($id);
        //dd($request->all());

        // Obtener la información actual de la denuncia
        $denunciado = Denunciado::find($id);

        // Verificar si se encontró el denunciado
        if (!$denunciado) {
            return redirect()->route('rrhh.denuncias.listar')->with('error', 'No se ha encontrado datos de Denunciado con ese ID.');
        }

        // Actualizar la información con los datos del formulario
        $denunciado->id_denuncia = $id;
        $denunciado->nro_doc = $request->input('num-doc');
        $denunciado->apellido = strlen($request->input('apellido_denunciado')) == 0 ? NULL : strtoupper($request->input('apellido_denunciado'));
        $denunciado->nombre = strlen($request->input('nombres_denunciado')) == 0 ? NULL : strtoupper($request->input('nombres_denunciado'));
        $denunciado->tipo_doc = $request->input('tipo-doc');
        $denunciado->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
        $denunciado->fecha_nac = $request->input('fecha-nac');
        $denunciado->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
        $denunciado->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
        $denunciado->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
        $denunciado->vinculo_inst = $request->input('tipo-vinculo');
        $denunciado->vinculo_vict = strlen($request->input('vinculo-victima')) == 0 ? NULL : strtoupper($request->input('vinculo-victima'));

        if ($denunciado->save()) {
            return redirect()->route('rrhh.denuncias.listar')->with('mensaje', 'Denuncia modificada exitosamente.');
        } else {
            return redirect()->route('rrhh.denuncias.listar')->with('mensaje', 'No se ha podido modificar la Denuncia.');
        }

        try {
            $denunciado->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', 'Se ha agregado los datos de la Víctima');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }


    public function destroy($id_denuncia){
        try {
            $denunciado = Denunciado::where('id_denuncia', $id_denuncia)->first();
            //$victima = Victima::where('id_denuncia', $id_denuncia)->first();
            //dd($denuncia, $victima);

            if (!$denunciado){
                return redirect()->route('rrhh.denuncias.listar')->with('mensaje','No se encontró esa denuncia.');
            }

            //dd($denunciado);
            $denunciado->delete();

            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', 'Los datos del Denunciado han sido borrados.');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

}
