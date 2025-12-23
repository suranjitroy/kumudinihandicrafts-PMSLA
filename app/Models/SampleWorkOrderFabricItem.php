<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleWorkOrderFabricItem extends Model
{
    use HasFactory;

    public function sampleWorkOrder(){
        return $this->belongsTo(SampleWorkOrder::class);
    }
    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function bahar(){
        return $this->belongsTo(Bahar::class);
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
