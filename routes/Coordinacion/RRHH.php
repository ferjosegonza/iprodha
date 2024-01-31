<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Coordinacion\RRHH\NovedadesController;
use App\Http\Controllers\Coordinacion\RRHH\AgenteController;

//--Fer Jose
use App\Http\Controllers\Generales\ProtocoloController;
//--

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|RRHH']], function () {
    Route::get('rrhh/novedades', [NovedadesController::class, 'novedades'])->name('rrhh.novedades');
    Route::get('agente/buscar', [AgenteController::class, 'buscar'])->name('agente.buscar');
    Route::get('agente/historial', [AgenteController::class, 'historial'])->name('agente.historial');
    Route::get('{id}/crear_novedad', [NovedadesController::class, 'crear_novedad'])->name('agente.crear_novedad');
    Route::get('novedad/avalatorios', [NovedadesController::class, 'getAvalatorios'])->name('novedad.avalatorios');
    Route::get('agente/pdfHistorial', [AgenteController::class, 'imprimirHistorial'])->name('agente.pdf');
    Route::post('agente/guardarNovedad', [NovedadesController::class, 'guardarNovedad'])->name('agente.crearNovedad');
    Route::put('agente/modificarNovedad', [NovedadesController::class, 'modificarNovedad'])->name('agente.modificarNovedad');
    Route::delete('agente/borrarNovedad', [NovedadesController::class, 'borrarNovedad'])->name('agente.borrarNovedad');

    //Route::post('generales/formularioMostrar', [ProtocoloController::class, 'formularioMostrar'])->name('rrhh.formulario_mostrar');
    Route::get('rrhh/denuncias/listar', [ProtocoloController::class, 'listarDenuncias'])->name('rrhh.denuncias.listar');
    Route::get('rrhh/denuncias/ver/{id}', [ProtocoloController::class, 'verDenuncia'])->name('rrhh.denuncias.ver');
    Route::any('rrhh/denuncias/crear', [ProtocoloController::class, 'crearDenuncia'])->name('rrhh.denuncias.crear');
    Route::any('rrhh/denuncia/guardar', [ProtocoloController::class, 'guardarDenuncia'])->name('rrhh.denuncias.guardar');
    Route::get('rrhh/denuncia/modificar/{id}', [ProtocoloController::class, 'abrirModificarDenuncia'])->name('rrhh.denuncias.modificar');
    Route::patch('rrhh/denuncias/update/{id}', [ProtocoloController::class, 'guardarDenunciaModificada'])->name('rrhh.denuncias.update');
    Route::delete('denuncias/borrar/{id_denuncia}', [ProtocoloController::class, 'destroy'])->name('rrhh.denuncias.borrar');
    Route::get('rrhh/denuncias/intervinientes/{id}', [ProtocoloController::class, 'intervinientesDenuncia'])->name('rrhh.denuncias.intervinientes');

    Route::get('rrhh/denuncias/denunciante/ver/{id}', [ProtocoloController::class, 'verDenunciante'])->name('rrhh.denuncias.denunciante.ver');
    Route::any('rrhh/denuncias/denunciante/crear', [ProtocoloController::class, 'crearDenunciante'])->name('rrhh.denuncias.denunciante.crear');
    Route::any('rrhh/denuncia/denunciante/guardar', [ProtocoloController::class, 'guardarDenunciante'])->name('rrhh.denuncias.denunciante.guardar');
    Route::get('rrhh/denuncia/denunciante/modificar/{id}', [ProtocoloController::class, 'abrirModificarDenunciante'])->name('rrhh.denuncias.denunciante.modificar');
    Route::patch('rrhh/denuncias/denunciante/update/{id}', [ProtocoloController::class, 'guardarDenunciaModificada'])->name('rrhh.denuncias.denunciante.update');
    Route::delete('denuncias/borrar/denunciante/{id_denuncia}', [ProtocoloController::class, 'destroy'])->name('rrhh.denuncias.denunciante.borrar');

    Route::get('rrhh/denuncias/denunciado/ver/{id}', [ProtocoloController::class, 'verDenunciado'])->name('rrhh.denuncias.denunciado.ver');
    Route::any('rrhh/denuncias/denunciado/crear', [ProtocoloController::class, 'crearDenunciado'])->name('rrhh.denuncias.denunciado.crear');
    Route::any('rrhh/denuncia/denunciado/guardar', [ProtocoloController::class, 'guardarDenunciado'])->name('rrhh.denuncias.denunciado.guardar');
    Route::get('rrhh/denuncia/denunciado/modificar/{id}', [ProtocoloController::class, 'abrirModificarDenunciado'])->name('rrhh.denuncias.denunciado.modificar');
    Route::patch('rrhh/denuncias/denunciado/update/{id}', [ProtocoloController::class, 'guardarDenunciadoModificada'])->name('rrhh.denuncias.denunciado.update');
    Route::delete('denuncias/borrar/denunciado/{id_denuncia}', [ProtocoloController::class, 'destroy'])->name('rrhh.denuncias.denunciado.borrar');

    Route::get('rrhh/denuncias/victima/ver/{id}', [ProtocoloController::class, 'verVictima'])->name('rrhh.denuncias.victima.ver');
    Route::any('rrhh/denuncias/victima/crear', [ProtocoloController::class, 'crearVictima'])->name('rrhh.denuncias.victima.crear');
    Route::any('rrhh/denuncia/victima/guardar', [ProtocoloController::class, 'guardarVictima'])->name('rrhh.denuncias.victima.guardar');
    Route::get('rrhh/denuncia/victima/modificar/{id}', [ProtocoloController::class, 'abrirModificarVictima'])->name('rrhh.denuncias.victima.modificar');
    Route::patch('rrhh/denuncias/victima/update/{id}', [ProtocoloController::class, 'guardarVictimaModificada'])->name('rrhh.denuncias.victima.update');
    Route::delete('denuncias/borrar/victima/{id_denuncia}', [ProtocoloController::class, 'destroy'])->name('rrhh.denuncias.victima.borrar');
});


/*Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    //Route::get('generales/protocolo', [ProtocoloController::class, 'protocolo'])->name('generales.protocolo');
    //Route::any('rrhh/formulario_mostrar', [ProtocoloController::class, 'formularioMostrar'])->name('rrhh.formulariomostrar');
});*/