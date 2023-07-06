
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Obrasyfinan\Ofertas\ofe_obraController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_itemdetController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_sombreroController;
use App\Http\Controllers\Obrasyfinan\Ofertas\Ofe_cronogramaController;
use App\Http\Controllers\EmpresaController;
//use App\Http\Controllers\Obrasyfinan\Ofertas\vw_ofe_obrasController;


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEOBRA']], function () {
    //Route::get('/ofeobra', [vw_ofe_obrasController::class, 'index'])->name('ofeobra.index');
    //Route::get('/ofeobra/{idobra}/editar', [ofe_obraController::class, 'edit'])->name('ofeobra.editar');
    //Route::get('/ofeobra/crear', [ofe_obraController::class, 'create'])->name('ofeobra.crear');
    //Route::post('/ofeobra', [ofe_obraController::class, 'store'])->name('ofeobra.store');
    //Route::put('/oferobra/{unaOferta}', [ofe_obraController::class, 'update'])->name('ofeObra.update');
    //Route::delete('/ofeobra/eliminar/{unaOferta}', [ofe_obraController::class, 'destroy'])->name('ofeobra.destroy');
    // Route::post('/ofecrono/{id}/{mes}/items', [Ofe_cronogramaController::class, 'losItems']);
    // Route::post('/ofecrono/{mes}/{item}/buscar', [Ofe_cronogramaController::class, 'buscarItemMes']);
    // Route::resource('ofecrono', Ofe_cronogramaController::class);
    Route::get('estadosxobra/index', [ofe_obraController::class, 'indexEstado'])->name('estadosxobra.index');
    Route::get('estadosxobra/buscar/index', [ofe_obraController::class, 'indexEstadoBuscar'])->name('estadosxobra.buscar');
    Route::get('estadosxobra/{idobra}/estados', [ofe_obraController::class, 'verEstados'])->name('estadosxobra.verestados');
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
    Route::resource('ofeobraitemdet', Ofe_itemdetController::class);
});
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFEITEMDETOBRA']], function () {
    //Route::get('/ofeobraitemdet/detalleitem/{iditem}', [ofe_itemdetController::class, 'detalleItem'])->name('ofeobraitemdet.detalleitem');
    Route::get('/ofesombreroxobra/{idobra}/index', [Ofe_sombreroController::class,'index'])->name('ofesombreroxobra.indexx');
    Route::get('/ofesombreroxobra/create/{idobra}', [Ofe_sombreroController::class,'create'])->name('ofesombreroxobra.crear');
    Route::get('/ofesombreroxobra/{idobra}/editar', [Ofe_sombreroController::class,'editar'])->name('ofesombreroxobra.editar');
    Route::patch('/ofesombreroxobra/{idobra}/update', [Ofe_sombreroController::class,'update'])->name('ofesombreroxobra.actualizar');
    Route::delete('/ofesombreroxobra/{idobra}/{idsombrero}/eliminar', [Ofe_sombreroController::class,'destroy'])->name('ofesombreroxobra.eliminar');
    /////////    
    Route::resource('ofesombreroxobra', Ofe_sombreroController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OFECRONO']], function () {
    Route::post('/ofecrono/{mes}/{item}/{avance}/nuevo', [Ofe_cronogramaController::class, 'guardarCrono']);
    Route::post('/ofecrono/{item}/comprobar', [Ofe_cronogramaController::class, 'comprobarAvance']);
    Route::post('/ofecrono/{item}/infoitem', [Ofe_cronogramaController::class, 'infoItem']);
    Route::post('/ofecrono/{id}/{mes}/items', [Ofe_cronogramaController::class, 'losItems']);
    Route::post('/ofecrono/{mes}/{item}/buscar', [Ofe_cronogramaController::class, 'buscarItemMes']);
    Route::get('/ofecrono/porc/{id}', [Ofe_cronogramaController::class, 'indexPorc'])->name('ofecrono.porc');
    Route::resource('ofecrono', Ofe_cronogramaController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|EMPRESA|OFEOBRA']], function () {
    Route::post('/ofeobra/{idobra}/presentarSave', [ofe_obraController::class, 'presentarSave'])->name('ofeobra.presentarSave');
    Route::get('/ofeobra/{idobra}/presentar', [ofe_obraController::class, 'presentarOferta'])->name('ofeobra.presentar');    
    Route::post('/ofeobra/{idobra}/validar', [ofe_obraController::class, 'validarOferta'])->name('ofeobra.validar');
    Route::get('/ofeobra/{idobra}/rechazar', [ofe_obraController::class, 'rechazarOferta'])->name('ofeobra.rechazar');
    Route::get('/ofeobra/{idobra}/items/{iditem}', [ofe_obraController::class, 'recuperarSubItems'])->name('ofeobra.subitems');
    Route::get('/ofeobra/{idobra}/ver/validar', [ofe_obraController::class, 'verValidarOferta'])->name('ofeobra.vervalidar');
    Route::get('/ofeobra/{idobra}/pdf1', [ofe_obraController::class, 'pdf1'])->name('ofeobra.pdf1'); 
    Route::get('/ofeobra/{idobra}/pdf2', [ofe_obraController::class, 'pdf2'])->name('ofeobra.pdf2'); 
    Route::get('/ofeobra/{idobra}/pdf', [ofe_obraController::class, 'pdf'])->name('ofeobra.pdf'); 
    Route::get('/ofeobra/{idobra}/{opc}/pdfitems', [ofe_obraController::class, 'pdfItems'])->name('ofeobraItems.pdf'); 
    Route::get('/ofeobra/{idobra}/pdfdsmxmes', [ofe_obraController::class, 'pdfDsmxmes'])->name('ofeobraDesmes.pdf');
    Route::get('/ofeobra/{idobra}/pdfincitems', [ofe_obraController::class, 'pdfIncItems'])->name('ofeobraIncItems.pdf');
    Route::get('/ofeobra/{idobra}/pdfcurvades', [ofe_obraController::class, 'pdfCurvaDes'])->name('ofeobraCurvaDes.pdf');
    Route::get('/ofeobra/{idobra}/pdfcrono', [ofe_obraController::class, 'pdfCrono'])->name('ofeobraCrono.pdf');
    Route::get('/ofeobraprueba', [ofe_obraController::class, 'prueba']);
});

// Route::get('ajax-autocomplete-search', [EmpresaController::class,'buscarEmpresa']);