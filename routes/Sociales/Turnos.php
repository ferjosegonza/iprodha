
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Sociales\TurnosController;
//use App\Http\Controllers\Obrasyfinan\Ofertas\vw_ofe_obrasController;


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|SOCIALES']], function () {
    Route::get('sociales/turnos', [TurnosController::class, 'index'])->name('turnos.index');
    Route::get('sociales/nueva_cola', [TurnosController::class, 'nueva_cola'])->name('turnos.nueva_cola');
    Route::get('sociales/cola/{parameter}', [TurnosController::class, 'cola'])->name('turnos.cola');
    Route::get('sociales/verificarUsuario', [TurnosController::class, 'verificarUsuario'])->name('turnos.verificarUsuario');
    Route::post('sociales/reservarTurno',[TurnosController::class, 'reservarTurno'])->name('turnos.reservarTurno');
    Route::get('sociales/getTurnosByFecha', [TurnosController::class, 'getTurnosByFecha'])->name('turnos.getTurnosByFecha');
    Route::post('sociales/postCola', [TurnosController::class, 'postCola'])->name('turnos.postCola');
    Route::post('sociales/generarTurnos',[TurnosController::class, 'generarTurnos'])->name('turnos.generarTurnos');
    Route::delete('sociales/borrarCola',[TurnosController::class, 'borrarCola'])->name('turnos.borrarCola');
});