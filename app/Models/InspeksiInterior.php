<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiInterior extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_interior';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'foto_speedometer',
        'keterangan_speedometer',
        'foto_setir',
        'keterangan_setir',
        'foto_dasboard',
        'keterangan_dasboard',
        'foto_plafon',
        'keterangan_plafon',
        'foto_ac',
        'keterangan_ac',
        'foto_audio',
        'keterangan_audio',
        'foto_jok',
        'keterangan_jok',
        'foto_electric_spion',
        'keterangan_electric_spion',
        'foto_power_window',
        'keterangan_power_window',
        'foto_lain_lain',
        'keterangan_lain_lain',
    ];

}
