<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipt';
    protected $fillable = [
        'client_id',
        'date',
        'receipt_no',
        'series',
        'agency',
        'payor',
        'nature',
        'account_code',
        'amount',
        'teller',
        'collecting_officer',
    ];
}
