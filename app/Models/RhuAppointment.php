<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RhuAppointment extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'rhu_appointment';

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'client_id',
        'name',
        'type',
        'sub_type',
        'doctor',
        'dose_number',
        'date',
        'status',
        'contactNo',
        'email',
        'refer',
        'reason',
        'price',
        'result',
    ];
}
