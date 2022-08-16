<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;



//agregamos los siguientes controladores
use App\Http\Controllers\IprousuarioController;
use App\Http\Controllers\ConceptofacturacionController;

use App\Http\Controllers\Obras\ObrasController;
use App\Http\Controllers\Obras\ObrasCertifController;
use App\Http\Controllers\Barrio\BarrioController;
use App\Http\Controllers\Barrio\BarrioCostosController;


use App\Http\Controllers\EstadoObrasController;
use App\Http\Controllers\CategorialaboralController;
use App\Http\Controllers\PermisopruebaController;
use App\Http\Controllers\Obras84Controller;

//--Fernando
use App\Http\Controllers\ViajesController;
use App\Http\Controllers\JorgeController;
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


Route::get('/terrenos', function() {return view('terrenos.index');});
Route::get('/prueba', [JorgeController::class, 'index']);
Route::get('/jorge', [JorgeController::class, 'index']);



Auth::routes();

//Lisandro
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-CATEGORIALABORAL|EDITAR-CATEGORIALABORAL|BORRAR-CATEGORIALABORAL|CREAR-CATEGORIALABORAL']],function() {
    //Route::get('/lisandro', [EjemplolisandroController::class, 'index']);
    Route::get('/categorialaboral/pdf', [CategorialaboralController::class, 'pdf'])->name('categorialaboral.pdf');
    Route::resource('categorialaboral', CategorialaboralController::class);
});




Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN']], function(){
    Route::resource('permisoprueba', PermisopruebaController::class);
});


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-IPROUSUARIO|EDITAR-IPROUSUARIO|BORRAR-IPROUSUARIO|CREAR-IPROUSUARIO']], function () {
    Route::resource('iprousuarios', IprousuarioController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ESTADOOBRAS|EDITAR-ESTADOOBRAS|BORRAR-ESTADOOBRAS|CREAR-ESTADOOBRAS']], function () {
    Route::post('/estadoobrasempresas', [EstadoObrasController::class, 'empresas']);
    Route::post('/estadoobrasprogramas', [EstadoObrasController::class, 'programas']);
    Route::resource('estadoobras', EstadoObrasController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-CONCEPTOFACTURACION|EDITAR-CONCEPTOFACTURACION|BORRAR-CONCEPTOFACTURACION|CREAR-CONCEPTOFACTURACION']], function () {
    Route::resource('conceptofacturacion', ConceptofacturacionController::class);       
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OBRAS|EDITAR-OBRAS|BORRAR-OBRAS|CREAR-OBRAS|VER-OBRAS']], function () {
    Route::get('/obras', [ObrasController::class, 'index'])->name('index');
    Route::get('/obras/{id_obr}/editar', [ObrasController::class, 'edit'])->name('obras.editar');
    Route::put('/obras/{id_obr}', [ObrasController::class, 'update']);
    Route::delete('/obras/eliminar/{id_obr}', [ObrasController::class, 'destroy'])->name('obras.eliminar');
    //Route::get('/obras', [ObrasCertifController::class, 'index'])->name('index');
    Route::get('/obras/{id_obr}/detalle', [ObrasCertifController::class, 'detalle'])->name('obrasCertif.detalle');

    Route::get('/obras/crear', [ObrasController::class, 'create'])->name('obras.crear');
    Route::post('/obras', [ObrasController::class, 'store']);



    Route::resource('obras', ObrasController::class);
    //Route::get('/obras/{id_obr?}', [ObrasController::class, 'update'])->name('update');;
    //->middleware('auth');  //solo para asegurar el login. Aleternativo

});
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-BARRIO|EDITAR-BARRIO|BORRAR-BARRIO|CREAR-BARRIO|VER-BARRIO']], function () {
    Route::get('/barrio', [BarrioController::class, 'index'])->name('index');
    Route::get('/barrio/{barrio}/editar', [BarrioController::class, 'edit'])->name('barrio.editar');
    Route::put('/barrio/{barrio}', [BarrioController::class, 'update']);
    Route::delete('/barrio/eliminar/{barrio}', [BarrioController::class, 'destroy'])->name('barrio.eliminar');
    //Route::get('/obras', [ObrasCertifController::class, 'index'])->name('index');
    //Route::get('/barrio/{barrio}/detalle', [BarrioCertifController::class, 'detalle'])->name('barrioCertif.detalle');
    Route::get('/barrio/buscar', [BarrioController::class, 'buscar'])->name('barrio.buscar');
    Route::get('/barrio/crear', [BarrioController::class, 'create'])->name('barrio.crear');
    Route::post('/barrio', [BarrioController::class, 'store']);

    Route::resource('barrio', BarrioController::class);
});


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-BARRIO|EDITAR-BARRIO|BORRAR-BARRIO|CREAR-BARRIO|VER-BARRIO']], function () {
    //Route::resource('barriocostos', BarrioCostosController::class);
    Route::get('/barrio/{barrio}/vercostos', [BarrioCostosController::class, 'edit'])->name('barrio.verCostos');
    //Route::get('/obras/{id_obr?}', [ObrasController::class, 'update'])->name('update');;
    //->middleware('auth');  //solo para asegurar el login. Aleternativo
});
//--Fernando
//Route::get('/viajes',[ViajesController::class, 'index'])->name('viajes.index');
//Route::resource('viajes', ViajesController::class);

Route::get('/obras84',function()
        {//return view('welcome');
       return view('Obras84.VistaObras84');
    });

/*
route::get('/viajes',function() 
   {return view('welcome');});
*/


//Quique
/*
Route::group(['middleware' => ['auth','role_or_permission:Admin']], function () {

    Route::resource('estadocivil', EstadocivilController::class);
	Route::get('/estadocivil', [App\Http\Controllers\EstadocivilController::class, 'index'])->name('index');
    
    
});*/

Route::get('/estadocivil', [App\Http\Controllers\EstadocivilController::class, 'index'])->name('index');

//gabriel
use App\Http\Controllers\ob_operatoriaController;
Route::resource('gabriel',ob_operatoriaController::class);
//
