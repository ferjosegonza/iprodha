
<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;


use App\Http\Controllers\Presidencia\ConceptofacturacionController;
use App\Http\Controllers\Presidencia\EstadoObrasController;


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ESTADOOBRAS']], function () {
    Route::post('/estadoobras/estadoobrasempresas', [EstadoObrasController::class, 'empresas']);
    Route::post('/estadoobras/estadoobrasprogramas', [EstadoObrasController::class, 'programas']);
    Route::resource('estadoobras', EstadoObrasController::class);
});


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-CONCEPTOFACTURACION']], function () {
    Route::resource('conceptofacturacion', ConceptofacturacionController::class);       
});