<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//RUTAS PARA LOGIN
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

//LOGIN POR GOOGLE
Route::get('login/google', [LoginController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleProviderCallback']);

//RUTAS PARA CONTRASEÑA
Route::get('routes/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('routes/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('routes/password/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('routes/password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');




//Route::get('/create', [App\Http\Controllers\Auth\LoginController::class, 'username']);


Route::get('/test', [App\Http\Controllers\DriveController::class, 'createDirectory']);