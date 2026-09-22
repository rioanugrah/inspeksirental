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
            Route::post('inputHargaInspeksiSimpan', [App\Http\Controllers\CarsController::class, 'inputHargaInspeksiSimpan'])->name('cars.inputHargaInspeksiSimpan')->middleware('verified');

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

            Route::get('{id}/input_harga_inspeksi', [App\Http\Controllers\CarsController::class, 'inputHargaInspeksi'])->name('cars.inputHargaInspeksi')->middleware('verified');

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

            Route::get('{id}/inspeksi/{inspeksi_lain}/inspeksi_lain/tambah', [App\Http\Controllers\CarsController::class, 'tambah_inspeksi_lain'])->name('cars.tambah_inspeksi_lain')->middleware('verified');

        });
        Route::prefix('inspeksi')->group(function(){
            Route::prefix('interior')->group(function(){
                Route::post('{id}/speedometer/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_speedometer'])->name('cars.upload_file_inspeksi_interior_speedometer')->middleware('verified');
                Route::post('{id}/setir/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_setir'])->name('cars.upload_file_inspeksi_interior_setir')->middleware('verified');
                Route::post('{id}/dasboard/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_dasboard'])->name('cars.upload_file_inspeksi_interior_dasboard')->middleware('verified');
                Route::post('{id}/plafon/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_plafon'])->name('cars.upload_file_inspeksi_interior_plafon')->middleware('verified');
                Route::post('{id}/ac/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_ac'])->name('cars.upload_file_inspeksi_interior_ac')->middleware('verified');
                Route::post('{id}/audio/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_audio'])->name('cars.upload_file_inspeksi_interior_audio')->middleware('verified');
                Route::post('{id}/jok/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_jok'])->name('cars.upload_file_inspeksi_interior_jok')->middleware('verified');
                Route::post('{id}/electric_spion/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_electric_spion'])->name('cars.upload_file_inspeksi_interior_electric_spion')->middleware('verified');
                Route::post('{id}/power_window/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_power_window'])->name('cars.upload_file_inspeksi_interior_power_window')->middleware('verified');
                Route::post('{id}/lain_lain/upload', [App\Http\Controllers\CarsController::class, 'upload_file_inspeksi_interior_lain_lain'])->name('cars.upload_file_inspeksi_interior_lain_lain')->middleware('verified');
            });
        });

        Route::prefix('jasa')->group(function(){
            Route::prefix('biaya_jasa')->group(function(){
                Route::get('/', [App\Http\Controllers\JasaController::class, 'biaya_jasa'])->name('jasa.biayaJasa')->middleware('verified');
                Route::post('simpan', [App\Http\Controllers\JasaController::class, 'biaya_jasa_simpan'])->name('jasa.biayaJasa.simpan')->middleware('verified');
                Route::post('pembayaran/simpan', [App\Http\Controllers\JasaController::class, 'biaya_jasa_metodePembayaran_simpan'])->name('jasa.biayaJasa.pembayaran.simpan')->middleware('verified');
                Route::post('pembayaranFinance/simpan', [App\Http\Controllers\JasaController::class, 'biaya_jasa_finance_simpan'])->name('jasa.biayaJasa.pembayaranFinance.simpan')->middleware('verified');
                Route::get('{id}', [App\Http\Controllers\JasaController::class, 'biaya_jasa_detail'])->name('jasa.biayaJasa.detail')->middleware('verified');
            });
        });
        
        Route::prefix('finance')->group(function(){
            Route::prefix('coa')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceCoaController::class, 'index'])->name('finance.coa')->middleware('verified');
                Route::post('simpan', [App\Http\Controllers\FinanceCoaController::class, 'simpan'])->name('finance.coa.simpan')->middleware('verified');
                Route::get('{id}', [App\Http\Controllers\FinanceCoaController::class, 'detail'])->name('finance.coa.detail')->middleware('verified');
            });
            Route::prefix('journal')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceJournalController::class, 'index'])->name('finance.journal')->middleware('verified');
                Route::post('simpan', [App\Http\Controllers\FinanceJournalController::class, 'simpan'])->name('finance.journal.simpan')->middleware('verified');
                Route::post('update', [App\Http\Controllers\FinanceJournalController::class, 'update'])->name('finance.journal.update')->middleware('verified');
                Route::get('downloadLaporanBulanan', [App\Http\Controllers\FinanceJournalController::class, 'downloadLaporanBulanan'])->name('finance.journal.downloadLaporanBulanan')->middleware('verified');
                Route::get('downloadLaporanTahunan', [App\Http\Controllers\FinanceJournalController::class, 'downloadLaporanTahunan'])->name('finance.journal.downloadLaporanTahunan')->middleware('verified');
                Route::get('{id}', [App\Http\Controllers\FinanceJournalController::class, 'detail'])->name('finance.journal.detail')->middleware('verified');
                Route::delete('{id}/delete', [App\Http\Controllers\FinanceJournalController::class, 'delete'])->name('finance.journal.delete')->middleware('verified');
            });
            Route::prefix('buku_besar')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceBukuBesarController::class, 'index'])->name('finance.buku_besar')->middleware('verified');
                Route::get('downloadLaporanBulanan', [App\Http\Controllers\FinanceBukuBesarController::class, 'downloadLaporanBulanan'])->name('finance.buku_besar.downloadLaporanBulanan')->middleware('verified');
                Route::get('downloadLaporanTahunan', [App\Http\Controllers\FinanceBukuBesarController::class, 'downloadLaporanTahunan'])->name('finance.buku_besar.downloadLaporanTahunan')->middleware('verified');
            });
            Route::prefix('lajur')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceLajurController::class, 'index'])->name('finance.lajur')->middleware('verified');
                Route::get('downloadLaporanBulanan', [App\Http\Controllers\FinanceLajurController::class, 'downloadLaporanBulanan'])->name('finance.lajur.downloadLaporanBulanan')->middleware('verified');
                Route::get('downloadLaporanTahunan', [App\Http\Controllers\FinanceLajurController::class, 'downloadLaporanTahunan'])->name('finance.lajur.downloadLaporanTahunan')->middleware('verified');
            });
            Route::prefix('laba_rugi')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceLabaRugiController::class, 'index'])->name('finance.laba_rugi')->middleware('verified');
                Route::get('periode', [App\Http\Controllers\FinanceLabaRugiController::class, 'report_period'])->name('finance.laba_rugi.report_period')->middleware('verified');
                Route::get('downloadLaporanBulanan', [App\Http\Controllers\FinanceLabaRugiController::class, 'downloadLaporanBulanan'])->name('finance.laba_rugi.downloadLaporanBulanan')->middleware('verified');
                Route::get('downloadLaporanTahunan', [App\Http\Controllers\FinanceLabaRugiController::class, 'downloadLaporanTahunan'])->name('finance.laba_rugi.downloadLaporanTahunan')->middleware('verified');
            });
            Route::prefix('neraca')->group(function(){
                Route::get('/', [App\Http\Controllers\FinanceNeracaController::class, 'index'])->name('finance.neraca')->middleware('verified');
                Route::get('periode', [App\Http\Controllers\FinanceNeracaController::class, 'report_period'])->name('finance.neraca.report_period')->middleware('verified');
                Route::get('downloadLaporanBulanan', [App\Http\Controllers\FinanceNeracaController::class, 'downloadLaporanBulanan'])->name('finance.neraca.downloadLaporanBulanan')->middleware('verified');
                Route::get('downloadLaporanTahunan', [App\Http\Controllers\FinanceNeracaController::class, 'downloadLaporanTahunan'])->name('finance.neraca.downloadLaporanTahunan')->middleware('verified');
            });
        });

        Route::prefix('laporan')->group(function(){
            Route::prefix('keuangan')->group(function(){
                Route::get('/', [App\Http\Controllers\LaporanKeuanganController::class, 'index'])->name('lap_keuangan.index')->middleware('verified');
                Route::get('cari', [App\Http\Controllers\LaporanKeuanganController::class, 'cari_data'])->name('lap_keuangan.cari_data')->middleware('verified');
                Route::get('export_pdf', [App\Http\Controllers\LaporanKeuanganController::class, 'export_pdf'])->name('lap_keuangan.export_pdf')->middleware('verified');
            });

            Route::prefix('inspeksi')->group(function(){
                Route::get('/', [App\Http\Controllers\LaporanInspeksiController::class, 'index'])->name('lap_inspeksi.index')->middleware('verified');
                Route::get('cari', [App\Http\Controllers\LaporanInspeksiController::class, 'cari_data'])->name('lap_inspeksi.cari_data')->middleware('verified');
                Route::get('{date}/download_rekap_inspeksi', [App\Http\Controllers\LaporanInspeksiController::class, 'download_rekap_inspeksi'])->name('lap_inspeksi.rekap_inspeksi')->middleware('verified');

            });
        });

        Route::post('get_regencies', function(){
            // dd(request()->all());
            $get_id = (int)request()->id;
            $data = \DB::table('regencies')->where('province_id',$get_id)->pluck('name','name');
            return response()->json($data);
            // dd($province_id);
        })->name('get_regencies');

    });

    // Route::get('testingProvince', function(){
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_FRESH_CONNECT  => true,
    //         CURLOPT_URL            => 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_HEADER         => false,
    //         // CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
    //         CURLOPT_FAILONERROR    => false,
    //         CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
    //     ));

    //     $response = curl_exec($curl);
    //     // dd($response);
    //     $error = curl_error($curl);

    //     curl_close($curl);

    //     foreach (json_decode($response) as $key => $province) {
    //         // dd($province->name);
    //         \DB::table('province')->insert([
    //             'id' => $province->id,
    //             'name' => $province->name,
    //         ]);

    //         curl_setopt_array($curl, array(
    //             CURLOPT_FRESH_CONNECT  => true,
    //             CURLOPT_URL            => 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/'.$province->id.'.json',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_HEADER         => false,
    //             // CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
    //             CURLOPT_FAILONERROR    => false,
    //             CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
    //         ));

    //         $response_regencies = curl_exec($curl);
    //         // dd($response);
    //         $error_regencies = curl_error($curl);

    //         curl_close($curl);

    //         foreach (json_decode($response_regencies) as $regencies) {
    //             \DB::table('regencies')->insert([
    //                 'province_id' => $regencies->province_id,
    //                 'name' => $regencies->name
    //             ]);

    //             // curl_setopt_array($curl, array(
    //             //     CURLOPT_FRESH_CONNECT  => true,
    //             //     CURLOPT_URL            => 'https://www.emsifa.com/api-wilayah-indonesia/api/districts/'.$regencies->id.'.json',
    //             //     CURLOPT_RETURNTRANSFER => true,
    //             //     CURLOPT_HEADER         => false,
    //             //     // CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
    //             //     CURLOPT_FAILONERROR    => false,
    //             //     CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
    //             // ));

    //             // $response_districts = curl_exec($curl);
    //             // // dd($response);
    //             // $error_districts = curl_error($curl);

    //             // curl_close($curl);

    //             // foreach (json_decode($response_districts) as $districts) {
    //             //     \DB::table('districts')->insert([
    //             //         'regency_id' => $districts->regency_id,
    //             //         'name' => $districts->name
    //             //     ]);

    //             //     curl_setopt_array($curl, array(
    //             //         CURLOPT_FRESH_CONNECT  => true,
    //             //         CURLOPT_URL            => 'https://www.emsifa.com/api-wilayah-indonesia/api/villages/'.$districts->id.'.json',
    //             //         CURLOPT_RETURNTRANSFER => true,
    //             //         CURLOPT_HEADER         => false,
    //             //         // CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
    //             //         CURLOPT_FAILONERROR    => false,
    //             //         CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
    //             //     ));

    //             //     $response_villages = curl_exec($curl);
    //             //     // dd($response);
    //             //     $error_villages = curl_error($curl);

    //             //     curl_close($curl);

    //             //     foreach (json_decode($response_villages) as $villages) {
    //             //         \DB::table('villages')->insert([
    //             //             'district_id' => $villages->district_id,
    //             //             'name' => $villages->name
    //             //         ]);
    //             //     }
    //             // }
    //         }
    //     }

    //     // return $response;
    // });

    Route::get('testinghome', function(){
    //    return ini_set('post_max_size', '50M');
       return ini_get('post_max_size');
    //    return phpinfo(); exit;
    });

});
