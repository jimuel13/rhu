<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RhuAnnouncement extends Model
{
    protected $table = 'rhu_announcement';
    protected $fillable = [
        'image',
        'title',
        'description',
        'date',
        'fullcontext',
        'isShow',
    ];
}
