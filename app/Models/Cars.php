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
}
