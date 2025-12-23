<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDistribution extends Model
{
    use HasFactory;

    public function masterInfo(){
        return $this->belongsTo(WorkerInfo::class);
    }
    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }

    public function orderDistributionItem(){
        return $this->belongsTo(OrderDistributionItem::class);
    }
    public function productionWorkOrder(){
        return $this->belongsTo(ProductionWorkOrder::class);
    }
    public function productionWorkOrderFabricItem(){
        return $this->belongsTo(ProductionWorkOrderFabricItem::class);
    }
    
}
