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
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes(
    [
        'verify' => true,
    ]
);

Route::domain(parse_url(env('APP_URL'), PHP_URL_HOST))->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');

        // Route::resource('users', App\Http\Controllers\UserController::class)->middleware('verified');
        Route::prefix('profile')->group(function(){
            Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile')->middleware('verified');
        });
        Route::prefix('users')->group(function(){
            Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users.index')->middleware('verified');
            Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create')->middleware('verified');
            Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store')->middleware('verified');
            Route::get('{id}/show', [App\Http\Controllers\UserController::class, 'show'])->name('users.show')->middleware('verified');
            Route::get('{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit')->middleware('verified');
            Route::patch('{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update')->middleware('verified');
            Route::get('{id}/destroy', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy')->middleware('verified');
        });
        Route::resource('roles', App\Http\Controllers\RolesController::class)->middleware('verified');
        Route::prefix('permissions')->group(function(){
            Route::get('/', [App\Http\Controllers\PermissionsController::class, 'index'])->name('permissions')->middleware('verified');
            Route::post('simpan', [App\Http\Controllers\PermissionsController::class, 'simpan'])->name('permissions.simpan')->middleware('verified');
            Route::post('update', [App\Http\Controllers\PermissionsController::class, 'update'])->name('permissions.update')->middleware('verified');
            // Route::get('{id}', [App\Http\Controllers\PermissionsController::class, 'show'])->name('permissions.show')->middleware('verified');
            Route::get('{id}/edit', [App\Http\Controllers\PermissionsController::class, 'edit'])->name('permissions.edit')->middleware('verified');
        });
        Route::prefix('cars')->group(function(){
            Route::get('/', [App\Http\Controllers\CarsController::class, 'index'])->name('cars')->middleware('verified');
            Route::get('create', [App\Http\Controllers\CarsController::class, 'create'])->name('cars.create')->middleware('verified');
            Route::post('simpan', [App\Http\Controllers\CarsController::class, 'store'])->name('cars.store')->middleware('verified');
            Route::post('sendMailInspeksi', [App\Http\Controllers\CarsController::class, 'sendMailInspeksi'])->name('cars.sendMailInspeksi')->middleware('verified');

            Route::get('{id}/detail', [App\Http\Controllers\CarsController::class, 'show'])->name('cars.detail')->middleware('verified');
            Route::get('{id}/inspeksi', [App\Http\Controllers\CarsController::class, 'buat_inspeksi'])->name('cars.buat_inspeksi')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_depan', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_depan'])->name('cars.simpan_inspeksi_depan')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_kiri', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_kiri'])->name('cars.simpan_inspeksi_kiri')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_belakang', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_belakang'])->name('cars.simpan_inspeksi_belakang')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_kanan', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_kanan'])->name('cars.simpan_inspeksi_kanan')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_interior', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_interior'])->name('cars.simpan_inspeksi_interior')->middleware('verified');
            Route::post('{id}/simpan_inspeksi_lain', [App\Http\Controllers\CarsController::class, 'simpan_inspeksi_lain'])->name('cars.simpan_inspeksi_lain')->middleware('verified');
            Route::get('{id}/edit', [App\Http\Controllers\CarsController::class, 'edit'])->name('cars.edit')->middleware('verified');
            Route::post('{id}/update', [App\Http\Controllers\CarsController::class, 'update'])->name('cars.update')->middleware('verified');
            Route::get('{id}/download', [App\Http\Controllers\CarsController::class, 'download'])->name('cars.download')->middleware('verified');
            Route::get('{id}/modalSendMail', [App\Http\Controllers\CarsController::class, 'modalSendMail'])->name('cars.modalSendMail')->middleware('verified');
            Route::get('{id}/delete', [App\Http\Controllers\CarsController::class, 'delete'])->name('cars.delete')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_depan}/inspeksi_depan', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_depan'])->name('cars.edit_inspeksi_depan')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_depan}/inspeksi_depan/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_depan'])->name('cars.update_inspeksi_depan')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_kiri}/inspeksi_kiri', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_kiri'])->name('cars.edit_inspeksi_kiri')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_kiri}/inspeksi_kiri/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_kiri'])->name('cars.update_inspeksi_kiri')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_belakang}/inspeksi_belakang', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_belakang'])->name('cars.edit_inspeksi_belakang')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_belakang}/inspeksi_belakang/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_belakang'])->name('cars.update_inspeksi_belakang')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_kanan}/inspeksi_kanan', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_kanan'])->name('cars.edit_inspeksi_kanan')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_kanan}/inspeksi_kanan/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_kanan'])->name('cars.update_inspeksi_kanan')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_interior}/inspeksi_interior', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_interior'])->name('cars.edit_inspeksi_interior')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_interior}/inspeksi_interior/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_interior'])->name('cars.update_inspeksi_interior')->middleware('verified');

            Route::get('{id}/inspeksi/{inspeksi_lain}/inspeksi_lain', [App\Http\Controllers\CarsController::class, 'edit_inspeksi_lain'])->name('cars.edit_inspeksi_lain')->middleware('verified');
            Route::post('{id}/inspeksi/{inspeksi_lain}/inspeksi_lain/update', [App\Http\Controllers\CarsController::class, 'update_inspeksi_lain'])->name('cars.update_inspeksi_lain')->middleware('verified');

        });
    });
});
