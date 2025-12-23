<?php

namespace App\Models;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'mobile_no',
        'email',
        'status'
    ];

    public function purchaseItem(){
       return $this->hasMany(PurchaseItem::class);
    }
    public function purchase(){
       return $this->hasMany(Purchase::class);
    }
}
