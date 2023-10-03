<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Coordinacion\Informatica\Tablero\Ju001Controller;
use App\Http\Controllers\Coordinacion\Informatica\Tablero\Re003Controller;
use App\Http\Controllers\Coordinacion\Informatica\Tablero\No001Controller;
use App\Http\Controllers\Coordinacion\Informatica\Tablero\At001Controller;
use App\Http\Controllers\App\AuthAppController;
use App\Http\Controllers\App\LegajoAppController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('/recaudacion', Ju001Controller::class)->middleware('auth:api');

// Route::apiResource('/ju001/juicios', Api_restController::class, 'juicios')->middleware('auth:api');

Route::group(['middleware' => ['auth:api']], function(){
    // Route::resource('myTable', 'Api\MyApiController');

    // Define new routes like this
    Route::get('/ju001/juicios', [Ju001Controller::class, 'juicios']);
    Route::get('/ju001/comparativo', [Ju001Controller::class, 'comparativo']);
    Route::get('/ju001/ultimo', [Ju001Controller::class, 'ultimo']);
    Route::get('/ju001/detallebajas', [Ju001Controller::class, 'detallebajas']);
    Route::get('/ju001/detallealtas', [Ju001Controller::class, 'detallealtas']);
    Route::get('/ju001/efectividad', [Ju001Controller::class, 'efectividad']);
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/re003/indice', [Re003Controller::class, 'indice']);
    Route::get('/re003/comparativointerior', [Re003Controller::class, 'comparativointerior']);
    Route::get('/re003/ultimoindicador', [Re003Controller::class, 'ultimoindicador']);
    Route::get('/re003/indicadorportipologia', [Re003Controller::class, 'indicadorportipologia']);
    Route::get('/re003/rangos', [Re003Controller::class, 'rangos']);
    Route::get('/re003/vigentedetalle', [Re003Controller::class, 'vigentedetalle']);
    Route::get('/re003/vigente', [Re003Controller::class, 'vigente']);
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/no001/comparativo', [No001Controller::class, 'comparativo']);
    Route::get('/no001/escrituras', [No001Controller::class, 'escrituras']);
    Route::get('/no001/historico', [No001Controller::class, 'historico']);
    Route::get('/no001/historicotipo', [No001Controller::class, 'historicotipo']);
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/at001/cancelaciones', [At001Controller::class, 'cancelaciones']);
});

Route::group(['middleware' => ['auth:api']], function(){
    Route::post('/registerApp', [AuthAppController::class, 'registerApp'])->name('app.register');
    Route::post('/loginApp', [AuthAppController::class, 'loginApp'])->name('app.login');
    Route::get('/legajos', [LegajoAppController::class, 'legajos'])->name('app.legajos');
    Route::get('/boletas', [LegajoAppController::class, 'boletas'])->name('app.boletas');
});