<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmbroideryOrderReceive extends Model
{
    use HasFactory;

    protected $fillable = [
        'receive_date',
        'embroidery_order_id',
        'receive_quantity',
        'remark',
        'status',
        'user_id',
    ];

    protected $attributes = [  
        'status' => '1'
    ];

    protected $casts =[
        'receive_date' => 'date',
    ];

    public function setReceiveDateAttribute($value)
    {
        $this->attributes['receive_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getReceiveDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
    public function embroideryOrder()
    {
        return $this->belongsTo(EmbroideryOrder::class);
    }

}
