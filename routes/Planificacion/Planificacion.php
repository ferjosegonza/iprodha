<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Planificacion\Planificacion\ObraviviendaController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OBRAVIVIENDA']], function () {
    //AJAX
    Route::post('/obravivienda/buscarviv/{orden}/{idobra}', [ObraviviendaController::class, 'buscarViviendaOrden']);
    Route::post('/obravivienda/todaslasviviendas/{id}', [ObraviviendaController::class, 'todasLasViviendas']);
    Route::post('/obravivienda/viviendasdelaetapa/{id}', [ObraviviendaController::class, 'todasLasViviendasDeUnaEtapa']);
    //-----
    Route::get('/obravivienda/nueva-viv/{id}', [ObraviviendaController::class, 'verNuevaViv'])->name('obravivienda.nuevaviv');

    Route::get('/obravivienda/nueva-viv-alt/{id}', [ObraviviendaController::class, 'verNuevaVivAlt'])->name('obravivienda.nuevavivalt');
    Route::get('/obravivienda/editar-viv/{viv}/{obra}', [ObraviviendaController::class, 'editarViv'])->name('obravivienda.editarviv');

    Route::post('/obravivienda/guardar-nueva-viv/{id}', [ObraviviendaController::class, 'guardarNuevaViv'])->name('obravivienda.guardarnuevaviv');
    Route::post('/obravivienda/asignarviviendas/{id}/{ideta}', [ObraviviendaController::class, 'asignarViviendas'])->name('obravivienda.asignarviviendas');
    Route::post('/obra/vivienda/{id}', [ObraviviendaController::class, 'viviendaDeObra']);
    Route::get('/obravivienda/viv/{id}', [ObraviviendaController::class, 'verViv'])->name('obravivienda.viviendas');
    Route::get('/obravivienda/eta-y-ent/{id}', [ObraviviendaController::class, 'verEta'])->name('obravivienda.etapas');
    Route::get('/obravivienda/eta/nueva/{id}', [ObraviviendaController::class, 'nuevaEta'])->name('obravivienda.nuevaetapa');
    Route::post('/obravivienda/eta/nueva/guardar', [ObraviviendaController::class, 'guardarNuevaEta'])->name('obravivienda.guardarnuevaetapa');
    Route::get('/obravivienda/eta/editar/{id}', [ObraviviendaController::class, 'verEditarEta'])->name('obravivienda.editaretapa');
    Route::post('/obravivienda/eta/editar/{id}/guardar', [ObraviviendaController::class, 'editarEta'])->name('obravivienda.guardareditaretapa');
    Route::delete('/obravivienda/eta/borrar/{id}', [ObraviviendaController::class, 'eliminarEta'])->name('obravivienda.eliminaretapa');
    Route::get('/obravivienda/ent/{id}/{entrega}', [ObraviviendaController::class, 'asignarVivEnt'])->name('obravivienda.entrega');
    Route::get('/obravivienda/entrega/nueva/{id}', [ObraviviendaController::class, 'verNuevaEnt'])->name('obravivienda.vernuevaentrega');
    Route::post('/obravivienda/entrega/guardar', [ObraviviendaController::class, 'guardarNuevaEnt'])->name('obravivienda.guardarnuevaentrega');
    Route::get('/obravivienda/entrega/editar/{id}/{idobra}', [ObraviviendaController::class, 'verEditarEnt'])->name('obravivienda.editarentrega');
    Route::post('/obravivienda/entrega/guardareditar/{id}', [ObraviviendaController::class, 'editarEnt'])->name('obravivienda.guaradreditarentrega');
    Route::delete('/obravivienda/entrega/borrar/{id}', [ObraviviendaController::class, 'eliminarEnt'])->name('obravivienda.eliminarentrega');
    Route::get('/obravivienda/cargamasi/{id}', [ObraviviendaController::class, 'cargaMasiva'])->name('obravivienda.cargamasiva');
    Route::post('/obravivienda/cargamasi/guardar/{id}', [ObraviviendaController::class, 'guardarCargaMasiva'])->name('obravivienda.guardarcargamasiva');
    Route::post('/obravivienda/viv/guardar/', [ObraviviendaController::class, 'guardarVivienda'])->name('obravivienda.guardarvivienda');
    Route::resource('obravivienda', ObraviviendaController::class);
});