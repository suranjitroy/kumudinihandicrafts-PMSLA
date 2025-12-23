<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDistributionItem extends Model
{
    use HasFactory;

    protected $casts =[
        'assing_entry_date' => 'date',
        'assing_delivery_date' => 'date',
    ];

    public function setAssingEntryDateAttribute($value)
    {
        $this->attributes['assing_entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getAssingEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
   
    public function setAssingDeliveryDateAttribute($value)
    {
        $this->attributes['assing_delivery_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getAssingDeliveryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    } 
    
    public function orderDistribution(){
        return $this->hasMany(OrderDistribution::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function bahar(){
        return $this->belongsTo(Bahar::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }
    public function workerInfo(){
        return $this->belongsTo(WorkerInfo::class);
    }
    public function productionWorkOrder(){
        return $this->belongsTo(ProductionWorkOrder::class);
    }
}
