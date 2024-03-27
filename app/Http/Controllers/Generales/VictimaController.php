<?php
//namespace App\Http\Controllers;
namespace App\Http\Controllers\Generales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\rrhh\Denuncias;
use App\Models\rrhh\Denunciante;
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

    public function abrirModificarVictima(Request $request, $id){
        $victima = Victima::find($id);
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.victima.modificar', compact('victima', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarVictimaModificada(Request $request, $id) {
        //dd($request->all());

        $victima = Victima::find($id);
        $denunciante = Denunciante::find($id);

        // Verificar si se encontró la victima
        if (!$victima) {
            return redirect()->route('rrhh.denuncias.listar')->with('error', 'Víctima no encontrada.');
        }

        if ($denunciante->es_victima){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id])->with('mensaje', 'La Víctima es también el Denunciante, se deben gestionar los datos a través de Denunciante.');
        }

        // Actualizar la información con los datos del formulario
        $victima->id_denuncia = $id;
        $victima->nro_doc = $request->input('num-doc');
        $victima->apellido = strlen($request->input('apellido_victima')) == 0 ? NULL : strtoupper($request->input('apellido_victima'));
        $victima->nombre = strlen($request->input('nombres_victima')) == 0 ? NULL : strtoupper($request->input('nombres_victima'));
        $victima->tipo_doc = $request->input('tipo-doc');
        $victima->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
        $victima->fecha_nac = $request->input('fecha-nac');
        $victima->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
        $victima->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
        $victima->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
        $victima->vinculo_inst = $request->input('tipo-vinculo');

        try {
            $victima->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id])->with('mensaje', 'Los datos de la Víctima se han modificado.');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id])->with('error', $e->getMessage());
        }
    }


    public function destroy($id_denuncia){
        try {
            $victima = Victima::where('id_denuncia', $id_denuncia)->first();
            //dd($denuncia, $victima);

            if (!$victima){
                return redirect()->route('rrhh.denuncias.listar')->with('mensaje','No se encontró esa denuncia.');
            }
            //dd($victima);

            $victima->delete();

            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', 'Los datos de la Víctima han sido borrados.');
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

}
