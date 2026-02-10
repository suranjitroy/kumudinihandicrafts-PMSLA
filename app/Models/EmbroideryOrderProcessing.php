<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmbroideryOrderProcessing extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_date',
        'embroidery_order_id',
        'process_section_id',
        'dispatch_quantity',
        'remark',
        'status',
        'user_id',
        'created_by',
        'updated_by'
    ];

    protected $casts =[
        'entry_date' => 'date'
        
    ];

    protected $attributes = [  
        'status' => '0'
    ];

    public function embroideryOrder()
    {
        return $this->belongsTo(EmbroideryOrder::class);
    }

    public function processSection()
    {
        return $this->belongsTo(ProcessSection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
