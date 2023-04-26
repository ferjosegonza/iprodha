<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Planificacion\Planificacion\ObraviviendaController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    Route::post('/obra/vivienda/{id}/{orden}', [ObraviviendaController::class, 'viviendaDeObra']);
    Route::get('/obravivienda/viv/{id}', [ObraviviendaController::class, 'verViv'])->name('obravivienda.viviendas');
    Route::get('/obravivienda/eta/{id}', [ObraviviendaController::class, 'verEta'])->name('obravivienda.etapas');
    Route::get('/obravivienda/ent/{id}/{entrega}', [ObraviviendaController::class, 'asignarVivEnt'])->name('obravivienda.entrega');
    Route::get('/obravivienda/cargamasi/{id}', [ObraviviendaController::class, 'cargaMasiva'])->name('obravivienda.cargamasiva');
    Route::post('/obravivienda/cargamasi/guardar/{id}', [ObraviviendaController::class, 'guardarCargaMasiva'])->name('obravivienda.guardarcargamasiva');
    Route::resource('obravivienda', ObraviviendaController::class);
});