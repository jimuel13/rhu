<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RhuClient extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'rhu_client';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'client_id',
        'name',
        'type',
        'sub_type',
        'doctor',
        'reason',
        'dose_number',
        'date',
        'result',
        'volume',
        'analysis',
        'status',
    ];
}
