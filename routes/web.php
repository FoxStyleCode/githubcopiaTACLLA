<?php

use App\Detalle;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/pruebas', function () {
    $detalles = Detalle::all();
    return $detalles;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['permission:crear-usuario|leer-usuarios|actualizar-usuario|eliminar-usuario']], function () {
    Route::resource('usuarios', 'UsersController');
});

Route::group(['middleware' => ['permission:crear-role|leer-roles|actualizar-role|eliminar-role|']], function () {
    Route::resource('roles', 'RolesController');
});

Route::group(['middleware' => ['permission:crear-proyecto|editar-proyecto|eliminar-proyecto|ver-proyecto|']], function () {
    Route::resource('proyectos', 'proyectosController');
    Route::resource('tipos', 'tipoController');
    Route::resource('nuevTarea', 'agregarTareasController');
});

Route::group(['middleware' => ['permission:crear-tareas|actualizar-tareas|eliminar-tareas|ver-tareas|']], function () {
    Route::resource('tareas', 'tareasController');
    Route::resource('estados', 'estadosController');
});

Route::group(['middleware' => ['permission:ver-log']], function () {
    Route::resource('logs', 'logController');
});

Route::group(['middleware' => ['auth']], function () {
    Route::resource('plantillas', 'plantillasControlador');
    Route::get('marcarLeidas', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Notificaciones leidas');
    })->name('marcarLeidas');
});


