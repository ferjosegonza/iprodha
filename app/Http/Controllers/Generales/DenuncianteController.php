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
use DateTime;
//use \PDF;


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
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.denunciante.crear', compact('denuncia', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarDenunciante(Request $request){
        $nvaDenunciante = new Denunciante;

        $id_denuncia = $request->input('id_denuncia');
        $nvaDenunciante->id_denuncia = $id_denuncia;
        $nvaDenunciante->nro_doc = $request->input('num-doc');
        $nvaDenunciante->apellido = strlen($request->input('apellido_denunciante')) == 0 ? NULL : strtoupper($request->input('apellido_denunciante'));
        $nvaDenunciante->nombre = strlen($request->input('nombres_denunciante')) == 0 ? NULL : strtoupper($request->input('nombres_denunciante'));
        $nvaDenunciante->tipo_doc = $request->input('tipo-doc');
        $nvaDenunciante->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
        $nvaDenunciante->fecha_nac = $request->input('fecha-nac');
        $nvaDenunciante->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
        $nvaDenunciante->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
        $nvaDenunciante->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
        $nvaDenunciante->vinculo_inst = $request->input('tipo-vinculo');

        if (isset($_POST['denunciante_victima'])){
            $nvaVictima = new Victima;

            // antes de crear el atributo 'es_victima' en el objeto '$nvaDenunciante',
            // copio todos los atrib creados hasta ahora de '$nvaDenunciante' a $nvaVictima y guardo
            $nvaVictima->setRawAttributes($nvaDenunciante->getAttributes());
            $nvaVictima->save();
            $mensaje = 'Se han agregado los datos de Denunciante y Victima';

            // ahora recién creo el otro atributo q sólo está en Denunciante pero no en Victima
            $nvaDenunciante->es_victima = 1;
        } else {
            $nvaDenunciante->es_victima = 0;
            $mensaje = 'Se han agregado los datos de Denunciante';
        }


        try {
            $nvaDenunciante->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', $mensaje);
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

    public function abrirModificarDenunciante(Request $request, $id){
        $denunciante = Denunciante::find($id);
        $todosLosTipdoc = Tipdoc::all();
        $todosLosSexo = Sexo::get();
        $todosLosVinculos = Vinculo::get();
        return view('rrhh.denuncias.denunciante.modificar', compact('denunciante', 'todosLosTipdoc', 'todosLosSexo', 'todosLosVinculos'));
    }

    public function guardarDenuncianteModificado(Request $request, $id) {
        //dd($id);
        //dd($request->all());

        // Obtener la información actual de la denuncia
        $denuncianteModif = Denunciante::find($id);

        // Verificar si se encontró la denuncia
        if (!$denuncianteModif) {
            return redirect()->route('rrhh.denuncias.listar')->with('error', 'Denunciante no encontrada.');
        }

        $id_denuncia = $request->input('id_denuncia');
        $denuncianteModif->id_denuncia = $id_denuncia;
        $denuncianteModif->nro_doc = $request->input('num-doc');
        $denuncianteModif->apellido = strlen($request->input('apellido_denunciante')) == 0 ? NULL : strtoupper($request->input('apellido_denunciante'));
        $denuncianteModif->nombre = strlen($request->input('nombres_denunciante')) == 0 ? NULL : strtoupper($request->input('nombres_denunciante'));
        $denuncianteModif->tipo_doc = $request->input('tipo-doc');
        $denuncianteModif->id_sexo = strlen($request->input('tipo-sex')) == 0 ? NULL : $request->input('tipo-sex');
        $denuncianteModif->fecha_nac = $request->input('fecha-nac');
        $denuncianteModif->domicilio = strlen($request->input('direccion')) == 0 ? NULL : strtoupper($request->input('direccion'));
        $denuncianteModif->mail = strlen($request->input('email')) == 0 ? NULL : strtoupper($request->input('email'));
        $denuncianteModif->telefono = strlen($request->input('tel')) == 0 ? NULL : strtoupper($request->input('tel'));
        $denuncianteModif->vinculo_inst = $request->input('tipo-vinculo');

        // si es victima tengo q cargar tb en esa tabla
        if (isset($_POST['denunciante_victima'])){

            //ver si ya existía y se está modificando una víctima existente
            $victimaModif = Victima::find($id_denuncia);

            // si es null, ahora se va a registrar como víctima
            if(is_null($victimaModif)) {
                $victimaModif = new Victima;
            }

            // antes de crear el atributo 'es_victima' en el objeto '$denuncianteModif',
            // copio todos los atrib creados hasta ahora de '$denuncianteModif' a $nvaVictima y guardo
            $victimaModif->setRawAttributes($denuncianteModif->getAttributes());
            $victimaModif->save();
            $mensaje = 'Se han modificado los datos de Denunciante y Victima';

            // ahora recién creo el otro atributo q sólo está en Denunciante pero no en Victima
            $denuncianteModif->es_victima = 1;
        } else {
            $denuncianteModif->es_victima = 0;
            $mensaje = 'Se han modificado los datos del Denunciante';
        }


        try {
            $denuncianteModif->save();
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', $mensaje);
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }


    public function destroy($id_denuncia){
        try {
            $denunciante = Denunciante::where('id_denuncia', $id_denuncia)->first();
            $victima = Victima::where('id_denuncia', $id_denuncia)->first();
            //dd($denuncia, $victima);

            if (!$denunciante){
                return redirect()->route('rrhh.denuncias.listar')->with('mensaje','No se encontró esa denuncia.');
            }
            //dd($denunciante);
            if ($denunciante->es_victima){
                $victima->delete();
                $mensaje = 'Los datos del Denunciante y Víctima han sido borrados.';
            } else {
                $mensaje = 'Los datos del Denunciante han sido borrados.';
            }

            $denunciante->delete();

            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('mensaje', $mensaje);
        } catch (\Exception $e){
            return redirect()->route('rrhh.denuncias.intervinientes', ['id' => $id_denuncia])->with('error', $e->getMessage());
        }
    }

}
