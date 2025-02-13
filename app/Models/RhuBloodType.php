<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuBloodType extends Model
{
   // Define the table name
   protected $table = 'rhu_blood_type';

   // Define the fillable properties
   protected $fillable = [
       'blood_type',
       'total',
       'current',
       'turned_over',

   ];
}
