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
    Route::get('rrhh/listar_denuncias', [ProtocoloController::class, 'listarDenuncias'])->name('rrhh.listardenuncias');
    //Route::get('rrhh/cargar_denuncia', [ProtocoloController::class, 'cargarDenuncia'])->name('rrhh.cargardenuncia');
    Route::any('denuncia/guardar', [ProtocoloController::class, 'crearDenuncia'])->name('denuncia.guardar');
    //Route::put('denuncia/modificar', [ProtocoloController::class, 'modificarDenuncia'])->name('denuncia.modificar');
    Route::match(['post', 'put'], 'denuncia/modificar', [ProtocoloController::class, 'modificarDenuncia'])->name('denuncia.modificar');
    //Route::post('denuncia/ver', [ProtocoloController::class, 'verDenuncia'])->name('denuncia.ver');
    Route::delete('denuncia/borrar/{id_denuncia}', [ProtocoloController::class, 'destroy'])->name('denuncia.borrar');
});


/*Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    //Route::get('generales/protocolo', [ProtocoloController::class, 'protocolo'])->name('generales.protocolo');
    //Route::any('rrhh/formulario_mostrar', [ProtocoloController::class, 'formularioMostrar'])->name('rrhh.formulariomostrar');
});*/