<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiKiri extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_bagian_kiri';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'fender_depan_kiri',
        'foto_fender_depan_kiri',
        'kaki_depan_kiri',
        'foto_kaki_depan_kiri',
        'kaki_belakang_kiri',
        'foto_kaki_belakang_kiri',
        'pintu_depan_kiri',
        'foto_pintu_depan_kiri',
        'pintu_belakang_kiri',
        'foto_pintu_belakang_kiri',
        'fender_belakang_kiri',
        'foto_fender_belakang_kiri',
    ];

}
