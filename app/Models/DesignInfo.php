<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DesignInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'design_entry_date',
        'design_no',
        'product_name',
        'design_name',
        'design_code',
        'description',
        'material_setup_id',
        'design_image',
        'remarks',
        'user_id'
    ];

    protected $casts =[
        'design_entry_date' => 'date'
    ];

    public function materialSetup(){
        return $this->belongsTo(MaterialSetup::class);
    }

     // Mutator: when saving, store as Y-m-d
    public function setDesignEntryDateAttribute($value)
    {
        $this->attributes['design_entry_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    // Accessor: when retrieving, show as d-m-Y
    public function getDesignEntryDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
