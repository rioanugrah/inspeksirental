<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cars extends Model
{
    use SoftDeletes;
    public $table = 'cars';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'no_reference',
        'plat_nomor',
        'warna',
        'merk',
        'model',
        'tahun',
        'no_rangka',
        'transmisi',
        'foto_kendaraan',
        'foto_stnk',
        'foto_sisi_depan',
        'foto_sisi_belakang',
        'foto_sisi_kanan',
        'foto_sisi_kiri',
        'foto_sisi_interior',
        'status',
    ];

    public function detail_inspeksi_depan()
    {
        return $this->belongsTo(\App\Models\InspeksiDepan::class, 'id','cars_id');
    }
    public function detail_inspeksi_kiri()
    {
        return $this->belongsTo(\App\Models\InspeksiKiri::class, 'id','cars_id');
    }
    public function detail_inspeksi_belakang()
    {
        return $this->belongsTo(\App\Models\InspeksiBelakang::class, 'id','cars_id');
    }
    public function detail_inspeksi_kanan()
    {
        return $this->belongsTo(\App\Models\InspeksiKanan::class, 'id','cars_id');
    }
    public function detail_inspeksi_interior()
    {
        return $this->belongsTo(\App\Models\InspeksiInterior::class, 'id','cars_id');
    }
    public function detail_inspeksi_lain()
    {
        return $this->belongsTo(\App\Models\InspeksiLain::class, 'id','cars_id');
    }
}
