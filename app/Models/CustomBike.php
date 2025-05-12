<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomBike extends Model
{
    protected $casts = [
        'configuration' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
