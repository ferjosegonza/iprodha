<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Coordinacion\Notarial\NotarialController;
use App\Http\Controllers\Coordinacion\Notarial\TramiteController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|NOTARIAL']], function () {
    Route::get('notarial/bandeja', [NotarialController::class, 'bandeja'])->name('notarial.bandeja');
    Route::get('notarial/alta_tramite', [NotarialController::class, 'alta_tramite'])->name('notarial.alta_tramite');
    Route::put('tramite/crear', [TramiteController::class, 'crear'])->name('tramite.alta');
    Route::get('notarial/escribano', [NotarialController::class, 'buscarEscribano'])->name('notarial.escribano');
    Route::get('notarial/beneficiario', [NotarialController::class, 'buscarBeneficiario'])->name('notarial.beneficiario');
    Route::get('notarial/documento', [NotarialController::class, 'buscarDocumento'])->name('notarial.documento');
    Route::get('tramite/{id}/movimientos', [NotarialController::class, 'movimientos'])->name('notarial.movimientos');
    Route::post('tramite/{id}/cerrar', [TramiteController::class, 'cerrar'])->name('tramite.cerrar');
    Route::get('tramite/gettramites', [TramiteController::class, 'getTramites'])->name('notarial.gettramites');
    Route::get('tramite/getmovimientos', [TramiteController::class, 'getMovimientos'])->name('notarial.getmovimientos');
    Route::put('tramite/nuevoMovimiento',[TramiteController::class, 'movimiento'])->name('tramite.movimiento');
});
