<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionChallanItem extends Model
{
    use HasFactory;

    public function challan()
    {
        return $this->belongsTo(ProductionChallan::class, 'production_challan_id');
    }
    public function size(){
        return $this->belongsTo(Size::class);
    }
}
