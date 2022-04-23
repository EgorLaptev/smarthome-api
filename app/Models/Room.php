<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'room';

    protected $fillable = [
        'name',
        'photo',
        'user_id'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

}
