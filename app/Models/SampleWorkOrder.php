<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SampleWorkOrder extends Model
{
    use HasFactory;
    
    protected $attributes = [  
        'status' => '0'
    ];

    protected $casts =[
        'order_entry_date' => 'date'
    ];

     public function masterInfo(){
        return $this->belongsTo(MasterInfo::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function sampleWorkOrderFabricItem(){
        return $this->hasMany(SampleWorkOrderFabricItem::class);
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
   

}
