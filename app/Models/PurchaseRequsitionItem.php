<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequsitionItem extends Model
{
    use HasFactory;
    protected $fillable = [

        'pur_requsition_no',
        'purchase_requsition_id',
        'material_setup_id',
        'pur_quantity',
        'unit_id',
        'unit_price',
        'purchase_req_price',
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
