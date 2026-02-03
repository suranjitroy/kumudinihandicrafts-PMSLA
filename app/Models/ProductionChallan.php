<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionChallan extends Model
{
    use HasFactory;


    protected $casts =[
        'pro_challan_date' => 'date'
    ];

    protected $attributes = [  
        'status' => '0'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(ProductionWorkOrder::class, 'production_work_order_id');
    }

    public function materialSetup()
    {
        return $this->belongsTo(MaterialSetup::class);
    }

        // Mutator: when saving, store as Y-m-d
    public function setProChallanDateAttribute($value)
    {
        $this->attributes['pro_challan_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getProChallanDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
