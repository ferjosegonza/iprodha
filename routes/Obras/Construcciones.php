<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;



//gabriel
use App\Http\Controllers\Obras\Construcciones\Inspectores\ob_operatoriaController;
use App\Http\Controllers\Obras\Construcciones\Inspectores\cargarFojaController;

//Lisandro
use App\Http\Controllers\Obras\Construcciones\CupoxobraController;
use App\Http\Controllers\Obras\Construcciones\ObrasxwebController;

Route::group(['middleware'=>['auth','role_or_permission:ADMIN|VER-CARGARFOJA']],function(){
    Route::resource('ob_operatoria',ob_operatoriaController::class);
    Route::resource('cargarfoja',cargarFojaController::class);
});

Route::group(['middleware'=>['auth','role_or_permission:ADMIN|VER-CUPOOBRA']],function(){
    Route::resource('cupoobra', CupoxobraController::class);
});

Route::group(['middleware'=>['auth','role_or_permission:ADMIN']],function(){
    Route::resource('obraweb', ObrasxwebController::class);
});