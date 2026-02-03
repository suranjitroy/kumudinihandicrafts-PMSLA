<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanGroup extends Model
{
    use HasFactory;

        protected $fillable = [
        'group_name',
        'group_address',
        'mobile_no',
        'remark',
        'status',
    ];
}
