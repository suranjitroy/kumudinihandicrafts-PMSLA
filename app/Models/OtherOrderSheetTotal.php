<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtherOrderSheetTotal extends Model
{
    use HasFactory;

    protected $attributes = [  
        'status' => '0'
    ];
    protected $casts =[
        'other_order_entry_date_t' => 'date'
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

     public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }

    // Mutator: when saving, store as Y-m-d
    public function setOtherOrderEntryDateTAttribute($value)
    {
        $this->attributes['other_order_entry_date_t'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getOtherOrderEntryDateTAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

}
