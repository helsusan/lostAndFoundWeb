<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function itemCategory(){
        return $this->belongsTo(ItemCategory::class);
    }

    public function itemStatus(){
        return $this->belongsTo(ItemStatus::class);
    }

    public function report(){
        return $this->hasOne(Report::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
