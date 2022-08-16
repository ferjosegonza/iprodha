<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

//--

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();



Route::group(['middleware' => ['auth','role:ADMIN']],function() {
    Route::resource('logs2', LogViewerController::class);
});
