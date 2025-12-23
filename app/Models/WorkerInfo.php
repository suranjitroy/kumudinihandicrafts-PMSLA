<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkerInfo extends Model
{
    use HasFactory;

       protected $casts =[
        'joining_date' => 'date'
    ];

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getJoiningDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    
}
