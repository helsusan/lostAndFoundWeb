<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
