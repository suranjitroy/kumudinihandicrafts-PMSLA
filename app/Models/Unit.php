<?php

namespace App\Models;

use App\Models\StoreRequsitionItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function purchaseitem(){
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
}
