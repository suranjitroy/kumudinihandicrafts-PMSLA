<?php

namespace App\Models;

use App\Models\ConsumptionSetupItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;

    protected $fillable=['size','status'];

    public function consumptionSetupItem(){
        return $this->hasMany(ConsumptionSetupItem::class);
    }
    public function unit(){
    return $this->belongsTo(Unit::class);
    }
}
