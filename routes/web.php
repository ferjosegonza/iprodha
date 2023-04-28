<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;



//agregamos los siguientes controladores
use App\Http\Controllers\Obras\ObrasController;
use App\Http\Controllers\Obras\ObrasCertifController;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\Barrio\BarrioController;
use App\Http\Controllers\Barrio\Fc_concosxbarrioController;


use App\Http\Controllers\CategorialaboralController;
use App\Http\Controllers\Obras84Controller;

//--Fernando
use App\Http\Controllers\JorgeController;
//--

use App\Http\Controllers\Terrenos\TerrenosController;

//sol
use App\Http\Controllers\pAlmacenController;
use App\Http\Controllers\sectorController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\NotificacionController;

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
Route::get('/ipusuario', function(Request $request){
    echo $request->ip();
            // server IP

            echo \Request::ip();
            // server IP

            echo \request()->ip();
            // server IP

            echo $this->getIp(); //see the method below
            // client IP
});

Route::get('/sintaxis',function()
    {return view('zsintaxis.LaravelCollective');})->name('sintaxis.index');

Route::get('/registerEmpIprodha',function(){
        return view('auth.registerEmp');
})->name('register.emp');

Route::get('/loginIprodha',function(){
    return view('auth.loginEmp');
})->name('login.iprodha');
// Jorge
//Route::get('/terrenos', [TerrenosController::class, 'index']);
Route::group(['middleware' => ['auth']], function(){
    Route::resource('terrenos', 'App\Http\Controllers\Terrenos\TerrenosController');
});

Auth::routes();

//Lisandro
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-CATEGORIALABORAL']],function() {
    //Route::get('/lisandro', [EjemplolisandroController::class, 'index']);
    Route::get('/categorialaboral/pdf', [CategorialaboralController::class, 'pdf'])->name('categorialaboral.pdf');
    Route::resource('categorialaboral', CategorialaboralController::class);
});


//Alumno
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-ALUMNOS']],function() {
    Route::resource('alumnos', AlumnoController::class);
});

//Ob_Concepto --Quqiue
use App\Http\Controllers\ge_Obras\di_Certificaciones\Conceptos\Ct_Ob_ConceptoController;
// Enrutamiento
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OB_CONCEPTO']],function() {
    Route::get('/editar_con/{id_concepto}',[Ct_Ob_ConceptoController::class, 'edit'])->name('ob_concepto.editar');
    Route::resource('r_ob_concepto', Ct_Ob_ConceptoController::class);
});

//Sol
//Ruta p_Almacen
Route::group(['middleware' => ['auth', 'role_or_permission:ADMIN|VER-ALMACENES']], function () {
    Route::get('p_almacen/{p_almacen}/imagen', [pAlmacenController::class, 'imagen'])->name('almacen.imagen');
    Route::get('p_almacen/{p_almacen}/asignar', [pAlmacenController::class, 'asignar'])->name('almacen.asignar');
    Route::put('p_almacen/{p_almacen}/imagen', [pAlmacenController::class, 'guardarImagen'])->name('almacen.guardarImagen');
    Route::put('p_almacen/{p_almacen}/sectores', [pAlmacenController::class, 'asignarSector'])->name('almacen.asignarSector');
    Route::get('p_almacen/crear', [pAlmacenController::class, 'create'])->name('almacen.crear');
    Route::get('p_almacen/index', [pAlmacenController::class, 'index'])->name('almacen.index');
    Route::get('p_almacen/{p_almacen}/editar', [pAlmacenController::class, 'edit'])->name('almacen.editar');
    Route::put('p_almacen/{p_almacen}',[pAlmacenController::class, 'update'])->name('almacen.update');
    Route::delete('p_almacen/eliminar/{id_almacen}', [pAlmacenController::class, 'destroy'])->name('almacen.eliminar');
    
    Route::resource('p_almacen', pAlmacenController::class); 
});
//Ruta sector
Route::group(['middleware'=> ['auth', 'role_or_permission:ADMIN|VER-SECTORES']], function(){
    Route::get('sector/crear', [sectorController::class, 'create'])->name('sector.crear');
    Route::get('sector/index', [sectorController::class, 'index'])->name('sector.index');
    Route::get('sector/{sector}/editar', [sectorController::class, 'edit'])->name('sector.editar');
    Route::put('sector/{sector}',[sectorController::class, 'update'])->name('sector.update');
    Route::delete('sector/eliminar/{id_sector}', [sectorController::class, 'destroy'])->name('sector.eliminar');
    Route::resource('sector', sectorController::class);
});


Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-OBRAS']], function () {
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
Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-BARRIO']], function () {
    Route::get('/barrio', [BarrioController::class, 'index'])->name('index');
    Route::get('/barrio/{barrio}/editar', [BarrioController::class, 'edit'])->name('barrio.editar');
    Route::put('/barrio/{barrio}', [BarrioController::class, 'update']);
    Route::delete('/barrio/eliminar/{barrio}', [BarrioController::class, 'destroy'])->name('barrio.eliminar');
    //Route::get('/obras', [ObrasCertifController::class, 'index'])->name('index');
    //Route::get('/barrio/{barrio}/detalle', [BarrioCertifController::class, 'detalle'])->name('barrioCertif.detalle');
    Route::get('/barrio/buscar', [BarrioController::class, 'buscar'])->name('barrio.buscar');
    Route::get('/barrio/crear', [BarrioController::class, 'create'])->name('barrio.crear');
    Route::post('/barrio', [BarrioController::class, 'store']);
    Route::get('/barrio/costos/editar', [BarrioController::class, 'edit'])->name('barrio.costos.editar');
    Route::resource('barrio', BarrioController::class);
});



Route::group(['middleware' => ['auth','role_or_permission:ADMIN|VER-BARRIO']], function () {
    //Route::resource('barriocostos', BarrioCostosController::class);
    Route::get('/barrio/{barrio}/vercostos', [Fc_concosxbarrioController::class, 'edit'])->name('barrio.verCostos');
    //Route::get('/obras/{id_obr?}', [ObrasController::class, 'update'])->name('update');;
    //->middleware('auth');  //solo para asegurar el login. Aleternativo
});

Route::get('/obras84',function()
        {//return view('welcome');
       return view('Obras84.VistaObras84');
    });


//Quique
/*
Route::group(['middleware' => ['auth','role_or_permission:Admin']], function () {

    Route::resource('estadocivil', EstadocivilController::class);
	Route::get('/estadocivil', [App\Http\Controllers\EstadocivilController::class, 'index'])->name('index');
    
    
});*/

Route::get('/estadocivil', [App\Http\Controllers\EstadocivilController::class, 'index'])->name('index');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/archivo', [ArchivoController::class, 'consultar'])->name('archivo.consultar');
    Route::get('/archivo/filtro', [ArchivoController::class, 'consultar'])->name('archivo.buscar');
    Route::get('/tipoarchivo/{id_tipoarchivo}/subtipos', [ArchivoController::class, 'subtipos'])->name('archivo.subtipos');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('{usuario}/notificaciones', [NotificacionController::class, 'verTodo'])->name('notif.verTodo');
    Route::get('{idnotificacion}/ver', [NotificacionController::class, 'visto'])->name('notif.ver');
    });//agregar noti

Route::group(['middleware' => ['auth']], function () {
    Route::get('archivos', [ArchivoController::class, 'consultar'])->name('archivos.consultar');
    Route::get('archivos/filtro', [ArchivoController::class, 'buscar'])->name('archivos.buscar');
    });
