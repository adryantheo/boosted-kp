<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Stand extends Model
{
    use SoftDeletes;
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
