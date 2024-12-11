<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'item_category_id',
        'location_id',
        'item_status_id',
        'name',
        'description',
        'location_found',
        'time_found',
        'image',
    ];
    
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
        return $this->belongsTo(Report::class);
    }
}
