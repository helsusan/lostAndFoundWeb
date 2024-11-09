<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }
}
