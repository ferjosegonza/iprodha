
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Obrasyfinan\Ofertas\ofe_obraController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemdetController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_sombreroController;
//use App\Http\Controllers\Obrasyfinan\Ofertas\vw_ofe_obrasController;


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEOBRA']], function () {
    //Route::get('/ofeobra', [vw_ofe_obrasController::class, 'index'])->name('ofeobra.index');
    //Route::get('/ofeobra/{idobra}/editar', [ofe_obraController::class, 'edit'])->name('ofeobra.editar');
    //Route::get('/ofeobra/crear', [ofe_obraController::class, 'create'])->name('ofeobra.crear');
    //Route::post('/ofeobra', [ofe_obraController::class, 'store'])->name('ofeobra.store');
    //Route::put('/oferobra/{unaOferta}', [ofe_obraController::class, 'update'])->name('ofeObra.update');
    //Route::delete('/ofeobra/eliminar/{unaOferta}', [ofe_obraController::class, 'destroy'])->name('ofeobra.destroy');
    Route::resource('ofeobra', ofe_obraController::class);
});
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEITEMOBRA']], function () {
    Route::get('/ofeobraitems/{idobra}', [Ofe_itemController::class, 'itemsxoferta'])->name('ofeobraitems.itemsoferta');
    Route::get('/ofeobraitems/{idobra}/sombrero', [Ofe_itemController::class, 'sombrerosxoferta'])->name('ofeobraitems.sombrerosxoferta');
    Route::get('/ofeobraitems/create/{idobra}', [Ofe_itemController::class, 'create'])->name('ofeobraitems.crear');
    Route::patch('/ofeobraitems/{unItem}/update', [Ofe_itemController::class, 'update'])->name('ofeobraitems.actualizar');
    Route::delete('/ofeobraitems/{idItem}', [Ofe_itemController::class, 'destroy'])->name('ofeobraitems.eliminar');
    Route::resource('ofeobraitems', Ofe_itemController::class);
});
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEITEMDETOBRA']], function () {
    Route::get('/ofeobraitemdet/detalleitem/{iditem}', [Ofe_itemdetController::class, 'detalleItem'])->name('ofeobraitemdet.detalleitem');
    Route::get('/ofeobraitemdet/create/{iditem}', [Ofe_itemdetController::class, 'create'])->name('ofeobraitemdet.crear');
    Route::get('/ofeobraitemdet/{unsubItem}/{unItem}/editar', [Ofe_itemdetController::class, 'edit'])->name('ofeobraitemdet.editar');
    Route::patch('/ofeobraitemdet/{iditem}/{idsubitem}/update', [Ofe_itemdetController::class, 'update'])->name('ofeobraitemdet.actualizar');
    Route::delete('/ofeobraitemdet/{idItem}/{idsubitem}/eliminar', [Ofe_itemdetController::class, 'destroy'])->name('ofeobraitemdet.eliminar');
    /////////    
    Route::resource('ofeobraitemdet', Ofe_itemdetController::class);
});
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEITEMDETOBRA']], function () {
    //Route::get('/ofeobraitemdet/detalleitem/{iditem}', [ofe_itemdetController::class, 'detalleItem'])->name('ofeobraitemdet.detalleitem');
    Route::get('/ofesombreroxobra/{idobra}/index', [Ofe_sombreroController::class,'index'])->name('ofesombreroxobra.indexx');
    Route::get('/ofesombreroxobra/create/{idobra}', [Ofe_sombreroController::class,'create'])->name('ofesombreroxobra.crear');
    Route::get('/ofesombreroxobra/{idobra}/editar', [Ofe_sombreroController::class,'editar'])->name('ofesombreroxobra.editar');
    Route::patch('/ofesombreroxobra/{idobra}/update', [Ofe_sombreroController::class,'update'])->name('ofesombreroxobra.actualizar');
    Route::delete('/ofesombreroxobra/{idobra}/eliminar', [Ofe_sombreroController::class,'destroy'])->name('ofesombreroxobra.eliminar');
    /////////    
    Route::resource('ofesombreroxobra', Ofe_sombreroController::class);
});