<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InspeksiLain extends Model
{
    use SoftDeletes;
    public $table = 'inspeksi_lain';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'body',
        // 'keterangan_lain_lain',
    ];

    public function cars()
    {
        return $this->belongsTo(\App\Models\Cars::class, 'cars_id', 'id');
    }

}
