<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PartCategory extends Model
{

    protected $fillable = [
        'bike_id',
        'name',
        'description',
    ];

    public function bike()
   {
       return $this->belongsTo(Bike::class);
   }


    public function parts()
    {
      return $this->hasMany(Part::class, 'category_id'); // Explicitly specify the foreign key
    }
}
