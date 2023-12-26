<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Coordinacion\Informatica\Tablero\TableroVistaController;
use App\Http\Controllers\App\AuthAppController;
use App\Http\Controllers\App\LegajoAppController;
use App\Http\Controllers\App\PagosAppController;
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

Route::group(['middleware' => ['auth:api']], function(){
    Route::get('/tc/{tablero}/{alias}', [TableroVistaController::class, 'obtenerDatos']);
});

Route::group(['middleware' => []], function(){
    Route::post('/registerApp', [AuthAppController::class, 'registerApp'])->name('app.register');
    Route::post('/loginApp', [AuthAppController::class, 'loginApp'])->name('app.login');
    Route::get('/legajos', [LegajoAppController::class, 'legajos'])->name('app.legajos');
    Route::get('/boletas', [LegajoAppController::class, 'boletas'])->name('app.boletas');
    Route::get('/boletasImpagas', [LegajoAppController::class, 'boletasImpagas'])->name('app.boletasImpagas');
    Route::get('/adeuda', [LegajoAppController::class, 'adeuda'])->name('app.adeuda');
    Route::post('/grabarPagoOnline', [PagosAppController::class, 'grabarPagoOnline'])->name('app.grabarPagoOnline');
    Route::get('/irMacroClick', [PagosAppController::class, 'irMacroClick'])->name('app.grabarPagoOnline');
});