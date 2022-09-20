<?php

use App\Models\Imagen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ImagenController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\EstablecimientoController;

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
//ruta de la pagina de inicio/pagina principal
Route::get('/', InicioController::class)->name('inicio');


//rutas con acceso solo para usuarios autenticados
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function(){
    //Registro de establecimiento
    Route::get('/create', [EstablecimientoController::class, 'create'])->name('establecimiento.create')->middleware('revisar');
    Route::post('/', [EstablecimientoController::class, 'store'])->name('establecimiento.store');
    //muestra la pagina de editar
    Route::get('/edit', [EstablecimientoController::class, 'edit'])->name('establecimiento.edit');
    
    //muestra formulario de datos para actulizar establiecimiento
    Route::put('/update/{establecimiento}', [EstablecimientoController::class, 'update'])->name('establecimiento.update');
    
    //ruta para el envio de imagenes
    Route::post('/imagenes/store', [ImagenController::class, 'store'])->name('imagenes.store');
    Route::post('/imagenes/destroy', [ImagenController::class, 'destroy'])->name('imagenes.destroy');
    
});
