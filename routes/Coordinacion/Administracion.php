<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Coordinacion\Administracion\Compras\Rubro\RubroController;


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-RUBRO']], function () {
    Route::get('/rubrosxemp',  [RubroController::class, 'empresaxrubro'])->name('rubros.empresa');
    Route::get('/rubrosxemp/asignar/{id}',  [RubroController::class, 'asignarRubro'])->name('rubroxemp.asignar');
    Route::resource('rubros', RubroController::class);
});
