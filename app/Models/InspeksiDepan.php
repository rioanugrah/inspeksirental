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
        'foto_kaca_depan',
        'kap_mesin',
        'foto_kap_mesin',
        'rangka_mobil',
        'foto_rangka_mobil',
        'aki',
        'foto_aki',
        'radiator',
        'foto_radiator',
        'kondisi_mesin',
        'foto_kondisi_mesin',
        'bumper_lampu',
        'foto_bumper_lampu',
    ];

}
