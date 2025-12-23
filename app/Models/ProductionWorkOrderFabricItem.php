<?php

namespace App\Models;

use App\Models\MaterialSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionWorkOrderFabricItem extends Model
{
    use HasFactory;

    public function productionWorkOrder(){
        return $this->belongsTo(ProductionWorkOrder::class);
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
    public function orderDistribution(){
        return $this->hasMany(orderDistribution::class);
    }
}
