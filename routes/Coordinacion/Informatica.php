<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\RolController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\UsuarioController;
use App\Http\Controllers\Coordinacion\Informatica\VistaController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\PermisoController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\ChangePasswordController;
use App\Http\Controllers\Coordinacion\Informatica\GestionUsuarios\ChangeEmailController;

use App\Http\Controllers\Coordinacion\Informatica\Ticket\TicketController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\SolucionadorController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\TiposolucionadorController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\CategoriaproblemaController;
use App\Http\Controllers\Coordinacion\Informatica\Ticket\CategoriaproblemasubController;
//use App\Http\Controllers\Coordinacion\Informatica\Ticket\TiposolucionadorController;

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




Route::get('/inicio', [HomeController::class, 'inicio'])->name('inicio');
Route::get('/', [HomeController::class, 'inicio'])->name('inicio');
Route::resource('home', HomeController::class);




Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-VISTAS']], function () {
    Route::get('/vistas/buscarvista', [VistaController::class, 'buscarvista']);
    Route::post('/vistas/editarvista', [VistaController::class, 'updatevista'])->name('vistas.updatevista');
    Route::resource('vistas', VistaController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ROL']], function () {
    Route::get('/roles/creargrupo', [RolController::class, 'creargrupo'])->name('roles.creargrupo');
    Route::post('/roles/buscarordengrupo', [RolController::class, 'buscarordengrupo']);
    Route::post('/roles/buscarmenus', [RolController::class, 'buscarmenus']);
    Route::get('/roles/vistas', [RolController::class, 'vistas']);
    Route::get('/roles/buscarvista', [RolController::class, 'buscarvista']);
    Route::post('/roles/buscarpermisos', [RolController::class, 'buscarpermisos']);
    Route::post('/roles/buscarmenu', [RolController::class, 'buscarmenu']);
    Route::delete('/roles/eliminarmenu/{id}', [RolController::class, 'eliminarmenu']);
    Route::post('/roles/editarmenu', [RolController::class, 'editarmenu']);
    Route::post('/roles/buscarrol', [RolController::class, 'buscarrol']);
    Route::post('/roles/guardargrupo', [RolController::class, 'storegrupo'])->name('roles.storegrupo');
    Route::resource('roles', RolController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-USUARIO']], function () {
    Route::get('/usuarios/pdf', [UsuarioController::class, 'pdf'])->name('usuarios.pdf');
    Route::post('/usuarios/rolesconpermisos', [UsuarioController::class, 'listarrolesconpremisos']);
    Route::post('/usuarios/rolessinpermisos', [UsuarioController::class, 'listarrolessinpremisos']);
    Route::post('/usuarios/buscarpermisosdelrol', [UsuarioController::class, 'buscarpermisosdelrol']);
    Route::post('/usuarios/buscarpermisos', [UsuarioController::class, 'buscarpermisos']);
    Route::resource('usuarios', UsuarioController::class);
});

Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-PERMISO']], function () {
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


Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN|VER-TICKET']], function(){
    Route::get('/ticket/asignar', [TicketController::class, 'asignadores'])->name('ticket.asigna');
    Route::get('/ticket/asignar/{id}/cancel', [TicketController::class, 'cancelticket'])->name('ticket.cancel');
    Route::get('/ticket/asignar/{id}/asignar', [TicketController::class, 'asigna'])->name('ticket.asignar');
    Route::get('/ticket/atencion', [TicketController::class, 'vertickets'])->name('ticket.atencion');
    Route::get('/ticket/atencion/{id}', [TicketController::class, 'atencionticket'])->name('ticket.atender');
    Route::get('/ticket/asignar/{id}/complete', [TicketController::class, 'completarticket'])->name('ticket.complete');
    Route::get('/ticket/validar/{id}', [TicketController::class, 'validarTicket'])->name('ticket.validar');
    Route::get('/ticket/reasignar/{id}', [TicketController::class, 'reAsignarTicket'])->name('ticket.reasignar');
    Route::patch('/ticket/editar/{id}', [TicketController::class, 'editarTicket'])->name('ticket.editar');
    Route::get('/ticket/cambiarCat/{id}', [TicketController::class, 'cambiarCategTicket'])->name('ticket.cambiar');
    Route::patch('/ticket/editarCat/{id}', [TicketController::class, 'editarCategTicket'])->name('ticket.cambiarcat');
    Route::post('/ticket/{id}/solu',[TicketController::class,'allTicket']);
    Route::resource('ticket', TicketController::class);
    
    // Route::get('/atender', [App\Http\Controllers\Coordinacion\Informatica\Ticket\TicketController::class, 'atencion']);
    Route::resource('solucionador', SolucionadorController::class);
    Route::resource('tiposolucionador', TiposolucionadorController::class);
    Route::post('/categoriaprob/{id}/subcateg',[CategoriaproblemaController::class,'byCategorias']);
    Route::post('/categoriaprob/{id}/solucionadores',[CategoriaproblemaController::class,'bySolucionadores']);
    Route::resource('categoriaprob', CategoriaProblemaController::class);
    Route::resource('categoriaprobsub', CategoriaproblemasubController::class);
});

// Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN']], function(){
//     Route::resource('tiposolucionador', TiposolucionadorController::class);
// });

