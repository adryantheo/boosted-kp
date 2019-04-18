<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Brand extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',        
        'description',
        'image',
    ];


    public function Products(){
        return $this->hasMany(Product::class);
    }

    public function Orders(){
        return $this->hasMany(Order::class);
    }

   
}
