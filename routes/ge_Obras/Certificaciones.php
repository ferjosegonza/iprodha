<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use app\Http\Controllers\ge_Obras\di_Certificaciones\Conceptos\Ct_Ob_ConceptoController;

use App\Http\Controllers\HomeController;

Route::get('/inicio', [HomeController::class, 'inicio'])->name('inicio');
Route::get('/', [HomeController::class, 'inicio'])->name('inicio');
Route::resource('home', HomeController::class);

Route::group(['middleware' => ['auth','role_or_permission:ADMIN']],function() {
    Route::resource('ge_Obras/di_Certificaciones/ob_concepto', Ct_Ob_ConceptoController::class);
});