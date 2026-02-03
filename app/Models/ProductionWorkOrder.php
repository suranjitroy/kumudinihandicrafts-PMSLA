<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionWorkOrder extends Model
{
    use HasFactory;

    protected $attributes = [  
        'status' => '0'
    ];

    protected $casts =[
        'order_entry_date' => 'date',
        'order_delivery_date' => 'date',
    ];

    public function masterInfo(){
        return $this->belongsTo(MasterInfo::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }

    public function productionWorkOrderFabricItem(){
        return $this->hasMany(ProductionWorkOrderFabricItem::class, 'production_work_order_id', 'id');
    }

    public function productionWorkOrderFabricItemID(){
        return $this->belongsTo(ProductionWorkOrderFabricItem::class);
    }

    public function orderDistribution(){
        return $this->hasMany(orderDistribution::class);
    }

    public function orderProcessing()
    {
        return $this->hasOne(OrderProcessing::class, 'production_work_order_id');
    }
    public function processSection(){
        return $this->belongsTo(ProcessSection::class);
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
