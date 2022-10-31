
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Construcciones\Certificacion\ofe_obraController;



Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEROBRA']], function () {
    Route::resource('ofeobra', ofe_obraController::class);
});
