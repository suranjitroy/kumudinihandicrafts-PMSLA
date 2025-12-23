<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionSetup extends Model
{
    use HasFactory;

    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function bahar(){
        return $this->belongsTo(Bahar::class);
    }
}
