<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiBelakang extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_bagian_belakang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'lampu_belakang',
        'keterangan_lampu_belakang',
        'foto_lampu_belakang',
        'pintu_bagasi_belakang',
        'keterangan_pintu_bagasi_belakang',
        'foto_pintu_bagasi_belakang',
        'bumper_belakang',
        'keterangan_bumper_belakang',
        'foto_bumper_belakang',
    ];

    public function cars()
    {
        return $this->belongsTo(\App\Models\Cars::class, 'cars_id', 'id');
    }

}
