<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseRequsition extends Model
{
    use HasFactory;

    protected $fillable = [
        'pur_requsition_date',
        'pur_requsition_no',
        'section_id',
        'total',
        'status',
        'user_id'
    ];
    protected $attributes = [  
        'status' => '0'
    ];

    protected $casts =[
        'pur_requsition_date' => 'date'
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    // Mutator: when saving, store as Y-m-d
    public function setPurRequsitionDateAttribute($value)
    {
        $this->attributes['pur_requsition_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getPurRequsitionDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
