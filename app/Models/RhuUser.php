<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RhuUser extends Authenticatable
{
    use HasFactory;
        protected $table = 'rhu_user';

        protected $fillable = [
            'f_name',
            'm_name',
            'l_name',
            'suffix',
            'bday',
            'gender',
            'contactNo',
            'street',
            'brgy',
            'zip_code',
            'municipality',
            'province',
              'address',
            'upload_id',
            'username',
            'email',
            'password',
            'department',
            'status',
            'profile_picture',
            'role'
        ];

        // Optional: If you want to hide certain attributes (like password) from JSON responses
        protected $hidden = [
            'password',
        ];
}
