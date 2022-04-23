<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device';

    protected $fillable = [
        'room_id',
        'type_id',
        'value',
        'name'
    ];

    public $timestamps = false;

    public function device_type()
    {
        return $this->hasOne(DeviceType::class, 'id', 'type_id');
    }

}
