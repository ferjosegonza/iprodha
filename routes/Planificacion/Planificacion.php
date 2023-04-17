<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Planificacion\Planificacion\ObraviviendaController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN']], function () {
    Route::resource('obravivienda', ObraviviendaController::class);
});