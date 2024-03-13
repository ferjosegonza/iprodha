<?php
//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
// use App\Models\rrhh\Denunciante;
use App\Models\rrhh\Denunciado;
use App\Models\rrhh\Victima;
use App\Models\rrhh\Sexo;
use App\Models\rrhh\Tipdoc;
use App\Models\rrhh\Vinculo;
// use DateTime;
//use \PDF;

class VictimaController extends Controller
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

    public function crearVictima(Request $request, $id){
        $denuncia = Denuncias::find($id);
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.victima.crear', compact('denuncia', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarVictima(Request $request){
        //$nvaDenunciante = new Denunciante;
        $nvaVictima = new Victima;

        $id_denuncia = $request->input('id_denuncia');
        $nvaVictima->id_denuncia = $id_denuncia;
        $nvaVictima->nro_doc = $request->input('num-doc');
        $nvaVictima->apellido = strlen($request->input('apellido_victima')) == 0 ? NULL : strtoupper($request->input('apellido_victima'));
        $nvaVictima->nombre = strlen($request->input('nombres_victima')) == 0 ? NULL : strtoupper($request->input('nombres_victima'));
        $nvaVictima->tipo_doc = $request->input('tipo-doc');
        $nvaVictima->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
        $nvaVictima->fecha_nac = $request->input('fecha-nac');
        $nvaVictima->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
        $nvaVictima->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
        $nvaVictima->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
        $nvaVictima->vinculo_inst = $request->input('tipo-vinculo');

        try {
            $nvaVictima->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', 'Se ha agregado los datos de la Víctima');
        } catch (\Exception $e){
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
            $denunciante = Denunciado::where('id_denuncia', $id_denuncia)->first();
            //$victima = Victima::where('id_denuncia', $id_denuncia)->first();
            //dd($denuncia, $victima);

            if (!$denunciante){
                return redirect()->route('rrhh.denuncias.listar')->with('mensaje','No se encontró esa denuncia.');
            }
            //dd($denunciante);
            if ($denunciante->es_victima){
                $victima->delete();
                $mensaje = 'Los registros de Denunciante y Víctima se borraron con éxito.';
            } else {
                $mensaje = 'El denunciante se borró con éxito.';
            }

            $denunciante->delete();

            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', $mensaje);
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

}
