<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmbroideryOrder extends Model
{
    protected $fillable = [
        'order_entry_date',
        'order_delivery_date',
        'emb_order_no',
        'artisan_group_id',
        'production_challan_id',
        'product_name',
        'design_name',
        'color_name',
        'description',
        'quantity',
        'unit_price',
        'total',
        'remark',
        'status',
        'user_id'
    ];

    protected $casts =[
        'order_entry_date' => 'date',
        'order_delivery_date' => 'date',
    ];

    protected $attributes = [  
        'status' => '0'
    ];

    public function artisanGroup()
    {
        return $this->belongsTo(ArtisanGroup::class);
    }

    public function productionChallan()
    {
        return $this->belongsTo(ProductionChallan::class);
    }

    public function setOrderEntryDateAttribute($value)
    {
        $this->attributes['order_entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getOrderEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
   
    public function setOrderDeliveryDateAttribute($value)
    {
        $this->attributes['order_delivery_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getOrderDeliveryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
