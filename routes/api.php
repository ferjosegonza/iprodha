<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Coordinacion\Informatica\Ju001Controller;

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

Route::post('/login', [AuthController::class, 'login']);

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

