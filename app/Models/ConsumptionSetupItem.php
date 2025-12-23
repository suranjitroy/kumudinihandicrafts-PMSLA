<?php

namespace App\Models;

use App\Models\Size;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsumptionSetupItem extends Model
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
    public function size(){
        return $this->belongsTo(Size::class);
    }
}
