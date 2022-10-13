
<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\HomeController;




Route::group(['middleware' => ['auth','role:ADMIN']],function() {
    Route::get('/logaudit', [HomeController::class, 'auditar'])->name('logaudit.index');
    Route::resource('logapp', LogViewerController::class);
});

Route::group(['middleware' => ['auth','role:ADMIN']],function() {
    Route::get('/phpinfo', [HomeController::class, 'phpinfo'])->name('phpinfo.index');
});