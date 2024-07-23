<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiKanan extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_bagian_kanan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'fender_depan_kanan',
        'foto_fender_depan_kanan',
        'kaki_depan_kanan',
        'foto_kaki_depan_kanan',
        'kaki_belakang_kanan',
        'foto_kaki_belakang_kanan',
        'pintu_depan_kanan',
        'foto_pintu_depan_kanan',
        'pintu_belakang_kanan',
        'foto_pintu_belakang_kanan',
        'fender_belakang_kanan',
        'foto_fender_belakang_kanan',
    ];

}
