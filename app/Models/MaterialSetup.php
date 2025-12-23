<?php

namespace App\Models;

use App\Models\Store;
use App\Models\PurchaseItem;
use App\Models\StoreCategory;
use App\Models\StoreRequsitionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialSetup extends Model
{
    use HasFactory;

    protected $fillable=['store_id','store_category_id','material_name', 'quantity', 'unit_id'];
    
    protected $attributes = [
        'quantity' => 0
    ];
    
    function store(){
    return $this->belongsTo(Store::class);
    }

    function storeCategory(){
    return $this->belongsTo(StoreCategory::class);
    }
    function unit(){
    return $this->belongsTo(Unit::class);
    }
    public function purchaseItem(){
        return $this->hasMany(PurchaseItem::class);
    }
    
    public function storeRequsitionItem(){
        return $this->hasMany(StoreRequsitionItem::class);
    }
    public function purRequsitionItem(){
        return $this->hasMany(StoreRequsitionItem::class);
    }
    public function consumptionSetupItem(){
        return $this->hasMany(ConsumptionSetupItem::class);
    }
    public function productionWorkOrderFabricItem(){
        return $this->hasMany(ConsumptionSetupItem::class);
    }
}
