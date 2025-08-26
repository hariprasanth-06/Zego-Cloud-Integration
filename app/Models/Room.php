<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'latitude',
        'longitude',
        'created_by',
    ];
}
