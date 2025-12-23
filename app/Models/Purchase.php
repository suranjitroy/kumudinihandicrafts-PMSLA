<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [

        'entry_date',
        'purchase_no',
        'total',
        'status',
        'user_id'

    ];
    protected $attributes = [
         
        'status' => '0'

    ];

    protected $casts =[
        'entry_date' => 'date'
    ];

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

    public function purchaseItem(){
        $this->hasMany(PurchaseItem::class);
    }

    public function supplier(){
       return $this->belongsTo(Supplier::class);
    }
    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }
    


}
