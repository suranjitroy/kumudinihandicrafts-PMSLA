<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahar extends Model
{
    use HasFactory;

        protected $fillable=['bahar'];

        public function consumptionSetupItem(){
        return $this->hasMany(ConsumptionSetupItem::class);
    }
}
