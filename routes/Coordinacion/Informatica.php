<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\RolController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\UsuarioController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\ChangePasswordController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\ChangeEmailController;

use App\Http\Controllers\Coordinacion\Informatica\Ticket\TicketController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\SolucionadorController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\TiposolucionadorController;

use App\Http\Controllers\HomeController;

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




Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'inicio'])->name('inicio');
Route::get('/', [App\Http\Controllers\HomeController::class, 'inicio'])->name('inicio');
Route::resource('home', HomeController::class);

Route::group(['middleware' => ['auth','role:ADMIN']],function() {
    Route::get('/phpinfo', [HomeController::class, 'phpinfo'])->name('phpinfo');
});

Route::group(['middleware' => ['auth','role:ADMIN']],function() {
    Route::get('/logAuditar', [HomeController::class, 'auditar'])->name('logAuditar');
    Route::resource('logApp', LogViewerController::class);
});


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ROL|EDITAR-ROL|BORRAR-ROL|CREAR-ROL']], function () {
    Route::resource('roles', RolController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-USUARIO|EDITAR-USUARIO|BORRAR-USUARIO|CREAR-USUARIO']], function () {
    Route::get('/usuarios/pdf', [UsuarioController::class, 'pdf'])->name('usuarios.pdf');
    Route::post('/usuarioss', [UsuarioController::class, 'index']);
    Route::post('/rolesconpermisos', [UsuarioController::class, 'listarrolesconpremisos']);
    Route::post('/rolessinpermisos', [UsuarioController::class, 'listarrolessinpremisos']);
    Route::post('/buscarpermisosdelrol', [UsuarioController::class, 'buscarpermisosdelrol']);
    Route::post('/buscarpermisos', [UsuarioController::class, 'buscarpermisos']);
    Route::resource('usuarios', UsuarioController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-PERMISO|EDITAR-PERMISO|BORRAR-PERMISO|CREAR-PERMISO']], function () {
    Route::resource('permisos', PermisoController::class);
});


Route::group(['middleware' => ['auth']],function() {
    //Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index']);
    //Route::post('/profile', [App\Http\Controllers\HomeController::class, 'store']);
    Route::resource('passwordedit', ChangePasswordController::class);
});

Route::group(['middleware' => ['auth']],function() {
    //Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index']);
    //Route::post('/profile', [App\Http\Controllers\HomeController::class, 'store']);
    // Route::post('/emailedit', ChangeEmailController::class, 'store');
    Route::resource('emailedit', ChangeEmailController::class);
});


Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN']], function(){
    Route::resource('ticket', TicketController::class);
});

Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN']], function(){
    Route::resource('solucionador', SolucionadorController::class);
    Route::resource('tiposolucionador', TiposolucionadorController::class);
});

// Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN']], function(){
//     Route::resource('tiposolucionador', TiposolucionadorController::class);
// });

