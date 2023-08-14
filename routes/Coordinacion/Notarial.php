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
});
