<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContratistaController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DriveController;

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
Route::get('routes/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('routes/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('routes/password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('routes/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
//LISTO

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE ROLES */

Route::group(['prefix' => '/', 'middleware' => []], function () {

    Route::get('rol/list', [RolController::class, 'index'])->name('rol.list');
    Route::post('rol/list', [RolController::class, 'findRolUser'])->name('rol.user.list');
  
});

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE USUARIOS */

Route::group(['prefix' => 'coordinador/', 'middleware' => []], function () {

    Route::get('user/list', [UserController::class, 'index'])->name('user.list');
    Route::get('user/create', [UserController::class, 'indexStore'])->name('user.store');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::post('user/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('user/delete', [UserController::class, 'destroy'])->name('user.delete');

    // CONTRATISTA
    Route::get('contratista/file/list', [ContratistaController::class, 'index'])->name('contratista.file.list');
    Route::post('contratista/file/list', [ContratistaController::class, 'showFile'])->name('contratista.file.list');

});//LISTO

/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE PROYECTOS */

Route::group(['prefix' => 'coordinador/', 'middleware' => []], function () {

    Route::get('proyect/list', [ProyectoController::class, 'index'])->name('proyect.list');
    Route::get('proyect/create', [ProyectoController::class, 'indexStore'])->name('proyect.store');
    Route::post('proyect/create', [ProyectoController::class, 'store'])->name('proyect.store');
    Route::post('proyect/edit', [ProyectoController::class, 'edit'])->name('proyect.edit');
    Route::post('proyect/delete', [ProyectoController::class, 'delete'])->name('proyect.delete');
});//LISTO



/** ----------------------------------------------------------------------------------------------------------------
 * CONTROL DE FILES */

Route::group(['prefix' => '/', 'middleware' => []], function () {

    Route::get('files/list', [FileController::class, 'index'])->name('file.list');
    Route::get('files/create', [FileController::class, 'store'])->name('file.store');
    Route::post('files/show', [FileController::class, 'show'])->name('file.show');
    Route::post('files/edit', [FileController::class, 'edit'])->name('file.edit');
    Route::post('files/delete', [FileController::class, 'destroy'])->name('file.delete');
});


Route::get('/test2', [FileController::class, 'store']);

Route::get('/test', [App\Http\Controllers\DriveController::class, 'getMail']);
