<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Coordinacion\Notarial\NotarialController;
use App\Http\Controllers\Coordinacion\Notarial\TramiteController;

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|NOTARIAL']], function () {
    Route::get('notarial/bandeja', [NotarialController::class, 'bandeja'])->name('notarial.bandeja');
    Route::get('notarial/alta_tramite', [NotarialController::class, 'alta_tramite'])->name('notarial.alta_tramite');
    Route::get('tramite/crear', [TramiteController::class, 'crear'])->name('tramite.alta');
});
