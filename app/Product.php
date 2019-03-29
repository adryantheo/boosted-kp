<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'units',
        'description',
        'image',
        'stand_id'
    ];
    
   

    public function Stand(){
        return $this->belongsTo(Stand::class, 'stand_id');
    }
    
}
