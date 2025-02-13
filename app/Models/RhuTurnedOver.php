<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuTurnedOver extends Model
{
     // Define the table name
     protected $table = 'rhu_turned_over';

     // Define the fillable properties
     protected $fillable = [

        'date',
         'name',
         'blood_type',
         'volume',
     ];
}
