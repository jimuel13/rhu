<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuMedicine extends Model
{
     // Define the table name
     protected $table = 'rhu_medicine';

     // Define the fillable properties
     protected $fillable = [
         'name',
         'total',
         'current',
         'turned_over',
     ];
}
