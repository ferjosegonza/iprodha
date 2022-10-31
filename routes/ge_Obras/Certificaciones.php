<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use app\Http\Controllers\ge_Obras\di_Certificaciones\Conceptos\Ct_Ob_ConceptoController;



Route::group(['middleware' => ['auth','role_or_permission:ADMIN']],function() {
    Route::resource('ge_Obras/di_Certificaciones/ob_concepto', Ct_Ob_ConceptoController::class);
});