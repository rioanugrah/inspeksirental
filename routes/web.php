<?php

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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('users', App\Http\Controllers\UserController::class)->middleware('verified');
    Route::resource('roles', App\Http\Controllers\RolesController::class)->middleware('verified');
    Route::prefix('permissions')->group(function(){
        Route::get('/', [App\Http\Controllers\PermissionsController::class, 'index'])->name('permissions')->middleware('verified');
        Route::post('simpan', [App\Http\Controllers\PermissionsController::class, 'simpan'])->name('permissions.simpan')->middleware('verified');
        Route::get('{id}', [App\Http\Controllers\PermissionsController::class, 'show'])->name('permissions.show')->middleware('verified');
        Route::get('{id}/edit', [App\Http\Controllers\PermissionsController::class, 'edit'])->name('permissions.edit')->middleware('verified');

    });
    Route::prefix('cars')->group(function(){
        Route::get('/', [App\Http\Controllers\CarsController::class, 'index'])->name('cars')->middleware('verified');
        Route::get('create', [App\Http\Controllers\CarsController::class, 'create'])->name('cars.create')->middleware('verified');
        Route::post('simpan', [App\Http\Controllers\CarsController::class, 'store'])->name('cars.store')->middleware('verified');
        Route::get('{id}/inspeksi', [App\Http\Controllers\CarsController::class, 'buat_inspeksi'])->name('cars.buat_inspeksi')->middleware('verified');
        Route::post('{id}/simpan_inspeksi', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi'])->name('cars.simpan_inspeksi')->middleware('verified');
        Route::get('{id}/edit', [App\Http\Controllers\CarsController::class, 'edit'])->name('cars.edit')->middleware('verified');
        Route::post('{id}/update', [App\Http\Controllers\CarsController::class, 'update'])->name('cars.update')->middleware('verified');
    });
});
