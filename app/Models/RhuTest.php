<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuTest extends Model
{
    // Define the table name
    protected $table = 'rhu_test';

    // Define the fillable properties
    protected $fillable = [
        'name',
        'price',
        'status',
    ];

}
