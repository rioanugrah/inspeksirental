<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceCoa extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'finance_coa';

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function debitJournals()
    {
        return $this->hasMany(\App\Models\FinanceJournal::class, 'code_debit', 'code');
    }

    public function creditJournals()
    {
        return $this->hasMany(\App\Models\FinanceJournal::class, 'code_credit', 'code');
    }
}
