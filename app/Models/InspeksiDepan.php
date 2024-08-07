<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiDepan extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_bagian_depan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'kaca_depan',
        'keterangan_kaca_depan',
        'foto_kaca_depan',
        'kap_mesin',
        'keterangan_kap_mesin',
        'foto_kap_mesin',
        'rangka_mobil',
        'keterangan_rangka_mobil',
        'foto_rangka_mobil',
        'aki',
        'keterangan_aki',
        'foto_aki',
        'radiator',
        'keterangan_radiator',
        'foto_radiator',
        'kondisi_mesin',
        'keterangan_kondisi_mesin',
        'foto_kondisi_mesin',
        'bumper_lampu',
        'keterangan_bumper_lampu',
        'foto_bumper_lampu',
    ];

    public function cars()
    {
        return $this->belongsTo(\App\Models\Cars::class, 'cars_id', 'id');
    }

}
