<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\Auth\LoginController;

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
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE ACCESO AL APLICATIVO */

//RUTAS PARA LOGIN
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

//LOGIN POR GOOGLE
Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback']);

//LOGOUT
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//RUTAS PARA CONTRASEÑA
Route::get('routes/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('routes/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('routes/password/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('routes/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE ROLES */

Route::group(['prefix' => '/', 'middleware' => []], function() {

    Route::get('rol/list', [RolController::class, 'index'])->name('rol.list');
    Route::post('rol/create', [RolController::class, 'store'])->name('rol.store');
    Route::post('rol/show', [RolController::class, 'show'])->name('rol.show');
    Route::post('rol/edit', [RolController::class, 'edit'])->name('rol.edit');
    Route::post('rol/delete', [RolController::class, 'destroy'])->name('rol.delete');

});

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE USUARIOS */

Route::group(['prefix' => '/', 'middleware' => []], function() {

    Route::get('user/list', [UserController::class, 'index'])->name('user.list');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::post('user/show', [UserController::class, 'show'])->name('user.show');
    Route::post('user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::post('user/rol/add', [UserController::class, 'aggRole'])->name('user.rol.add');
    Route::post('user/rol/destroy', [UserController::class, 'deleteRole'])->name('user.rol.destroy');

});

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE PROYECTOS */

Route::group(['prefix' => '/', 'middleware' => []], function() {

    Route::get('proyect/list', [ProyectoController::class, 'index'])->name('proyect.list');
    Route::post('proyect/create', [ProyectoController::class, 'store'])->name('proyect.store');
    Route::post('proyect/show', [ProyectoController::class, 'show'])->name('proyect.show');
    Route::post('proyect/edit', [ProyectoController::class, 'edit'])->name('proyect.edit');
    Route::post('proyect/delete', [ProyectoController::class, 'destroy'])->name('proyect.delete');

});

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE FILES */

Route::group(['prefix' => '/', 'middleware' => []], function() {

    Route::get('files/list', [FileController::class, 'index'])->name('file.list');
    Route::get('files/create', [FileController::class, 'store'])->name('file.store');
    Route::post('files/show', [FileController::class, 'show'])->name('file.show');
    Route::post('files/edit', [FileController::class, 'edit'])->name('file.edit');
    Route::post('files/delete', [FileController::class, 'destroy'])->name('file.delete');

});




Route::get('/test', [App\Http\Controllers\DriveController::class, 'getMail']);