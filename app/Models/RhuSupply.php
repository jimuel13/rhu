<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuSupply extends Model
{
     // Define the table name
     protected $table = 'rhu_supplies';

     // Define the fillable properties
     protected $fillable = [
         'name',
         'type',
         'batchNo',
         'dosage_f',
         'dosage_s',
         'expiration_date',
         'location_code',
         'quantity',
         'expiration',
         'end_user',
     ];
}
