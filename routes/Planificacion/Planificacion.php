<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Planificacion\Planificacion\ObraviviendaController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    Route::post('/obra/vivienda/{id}/{orden}', [ObraviviendaController::class, 'viviendaDeObra']);
    Route::get('/obravivienda/viv/{id}', [ObraviviendaController::class, 'verViv'])->name('obravivienda.viviendas');
    Route::get('/obravivienda/eta/{id}', [ObraviviendaController::class, 'verEta'])->name('obravivienda.etapas');
    Route::resource('obravivienda', ObraviviendaController::class);
});