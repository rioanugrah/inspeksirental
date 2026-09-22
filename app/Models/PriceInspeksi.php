<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceInspeksi extends Model
{
    // use HasFactory;
    use SoftDeletes;

    public $table = 'price_inspeksi';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $dates = ['deleted_at'];

    public $fillable = [
        'id',
        'cars_id',
        'price',
    ];

    public function cars()
    {
        return $this->belongsTo(\App\Models\Cars::class, 'cars_id', 'id');
    }

}
