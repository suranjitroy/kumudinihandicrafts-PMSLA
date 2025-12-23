<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\MaterialSetup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [

        'entry_date',
        'purchase_no',
        'purchase_id',
        'store_id',
        'store_category_id',
        'supplier_id',
        'material_setup_id',
        'buying_qty',
        'unit_id',
        'unit_price',
        'description',
        'purpose',
        'challan_no',
        'buying_price',
        'status',
        'user_id'

    ];

    
    protected $casts =[
        'entry_date' => 'date'
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function supplier(){
       return $this->belongsTo(Supplier::class);
    }
    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }

        // Mutator: when saving, store as Y-m-d
    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    // public function supplier(){
    //     $this->hasMany(Supplier::class);
    // }


}
