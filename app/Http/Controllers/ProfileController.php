<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    function __construct(
        User $user
    ){
        $this->user = $user;
    }

    public function index()
    {
        return view('backend.profiles.index');
    }

    public function update_password(Request $request)
    {
        $rules = [
            'new'  => 'required',
        ]; // Ini buat validasi inputan

        $messages = [
            'plat_nomor_tengah.required'  => 'Plat Nomor wajib diisi lengkap.',
            'warna.required'  => 'Warna Mobil wajib diisi.',
            'merk.required'  => 'Merek Mobil wajib diisi.',
            'model.required'  => 'Model Mobil wajib diisi.',
            'tahun.required'  => 'Tahun Mobil wajib diisi.',
            'no_rangka.required'  => 'No. Rangka Mobil wajib diisi.',
            'transmisi.required'  => 'Transmisi Mobil wajib diisi.',
            'foto_kendaraan.required'  => 'Foto Kendaraan Mobil wajib diisi.',
            'foto_stnk.required'  => 'Foto STNK Mobil wajib diisi.',
            'foto_sisi_depan.required'  => 'Foto Sisi Depan Mobil wajib diisi.',
            'foto_sisi_belakang.required'  => 'Foto Sisi Belakang Mobil wajib diisi.',
            'foto_sisi_kanan.required'  => 'Foto Sisi Kanan Mobil wajib diisi.',
            'foto_sisi_kiri.required'  => 'Foto Sisi Kiri Mobil wajib diisi.',
            'foto_sisi_interior.required'  => 'Foto Sisi Interior Mobil wajib diisi.',
        ]; // Ini buat nampilkan pesan ketika error
    }
}
