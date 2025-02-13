<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';

    protected $fillable = [
        'name',
        'department',
        'position',
        'activity',
        'date',
        'time_in',
        'time_out',
        'user_id',
    ];
}
