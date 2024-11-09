<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    public function items(){
        return $this->hasMany(Item::class);
    }
}
