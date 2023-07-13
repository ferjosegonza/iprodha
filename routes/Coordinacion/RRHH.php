<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Coordinacion\RRHH\NovedadesController;
use App\Http\Controllers\Coordinacion\RRHH\AgenteController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|RRHH']], function () {
    Route::get('rrhh/novedades', [NovedadesController::class, 'novedades'])->name('rrhh.novedades');
    Route::get('agente/buscar', [AgenteController::class, 'buscar'])->name('agente.buscar');
    Route::get('agente/historial', [AgenteController::class, 'historial'])->name('agente.historial');
    Route::get('{id}/crear_novedad', [NovedadesController::class, 'crear_novedad'])->name('agente.crear_novedad');
    Route::post('agente/guardarNovedad', [NovedadesController::class, 'guardarNovedad'])->name('agente.crearNovedad');
});
