<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\UsersController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::apiResource('/ciudads',CiudadController::class )->middleware('auth');
Route::apiResource('/users',UsersController::class )->middleware('auth');
Route::get('/ciudads/{id}', [UsersController::class, 'getCity'])->middleware('auth');
Route::get('/users-by-city', [UsersController::class, 'getUsersByCity'])->middleware('auth');
Route::get('/get-city-names', [UsersController::class, 'getCityNames'])->middleware('auth');

