<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatus extends Model
{
    public function reports(){
        return $this->hasMany(Report::class);
    }
}
