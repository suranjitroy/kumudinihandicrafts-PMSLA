<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class StoreRequsition extends Model
{
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'requsition_date',
        'requsition_no',
        'section_id',
        'status',
        'user_id'
    ];
    protected $attributes = [  
        'status' => '0'
    ];

    protected $casts =[
        'requsition_date' => 'date'
    ];

    public function section(){
        return $this->belongsTo(Section::class);
    }

    // Mutator: when saving, store as Y-m-d
    public function setRequsitionDateAttribute($value)
    {
        $this->attributes['requsition_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getRequsitionDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
