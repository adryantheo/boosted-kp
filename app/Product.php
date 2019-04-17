<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'units',
        'description',
        'image',
        'brand_id'
    ];
    
   

    public function Brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    
}
