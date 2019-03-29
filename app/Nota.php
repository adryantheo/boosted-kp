<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'harga_total',
        'customer'
    ];

    public function Order(){
        return $this->hasMany(Order::class);
    }
}
