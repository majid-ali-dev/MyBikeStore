<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = ['brand_name', 'model'];

    public function categories()
    {
        return $this->hasMany(PartCategory::class);
    }


    public function orders()
{
    return $this->hasMany(Order::class, 'brand_id');
}

}
