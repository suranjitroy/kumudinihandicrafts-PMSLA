<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderReceiveItem extends Model
{
    use HasFactory;

    protected $casts =[
        'receive_entry_date' => 'date',
    ];

    public function setReceiveEntryDateAttribute($value)
    {
        $this->attributes['receive_entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getReceiveEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
