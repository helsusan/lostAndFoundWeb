<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;
use App\Models\Item;
use App\Models\ReportStatus;

class Report extends Model
{

    protected $fillable = [
        'id',
        'item_id',           
        'user_id',          
        'location_id', 
        'report_status_id',      
        'description',       
        'image', 
        'is_verified',            
        'location_lost',     
        'time_lost',        
    ];


    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reportStatus(){
        return $this->belongsTo(ReportStatus::class);
    }


}
