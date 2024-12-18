<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'building'];

    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function items(){
        return $this->hasMany(Item::class);
    }
}
