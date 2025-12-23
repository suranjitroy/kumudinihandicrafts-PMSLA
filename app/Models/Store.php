<?php

namespace App\Models;

use App\Models\StoreCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    function storeCate(){
    return $this->hasMany(StoreCategory::class);
    }
}
