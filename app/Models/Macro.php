<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{
    use HasFactory;

    protected $table = 'macro';

    protected $fillable = [
        'name',
        'user_id'
    ];

    public $timestamps = false;

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

}
