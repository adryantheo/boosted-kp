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

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function stand(){
        return $this->belongsTo(Stand::class, 'stand_id');
    }
}
