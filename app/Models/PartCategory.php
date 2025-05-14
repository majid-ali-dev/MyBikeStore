<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartCategory extends Model
{

    protected $fillable = [
        'name',
        'description',
    ];


    public function parts()
    {
      return $this->hasMany(Part::class, 'category_id'); // Explicitly specify the foreign key
    }
}
