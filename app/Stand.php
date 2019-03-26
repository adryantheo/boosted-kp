<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = [
        'name',        
        'description',

    ];


    public function Products(){
        return $this->hasMany(Product::class);
    }

    public function Orders(){
        return $this->hasMany(Order::class);
    }

   
}
