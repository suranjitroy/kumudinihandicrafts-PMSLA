<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProcessing extends Model
{
    use HasFactory;

    public function productionWorkOrder(){
        return $this->belongsTo(ProductionWorkOrder::class);
    }
    public function processSection(){
        return $this->belongsTo(ProcessSection::class);
    }
}
