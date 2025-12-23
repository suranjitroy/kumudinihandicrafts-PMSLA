<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\MaterialSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreRequsitionItem extends Model
{
    use HasFactory;

     protected $fillable = [

        'requsition_no',
        'store_requsition_id',
        'material_setup_id',
        'quantity',
        'unit',
        'status',
        'user_id'

    ];

    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
