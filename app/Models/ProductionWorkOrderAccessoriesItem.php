<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionWorkOrderAccessoriesItem extends Model
{
    use HasFactory;

    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }

    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }
}
