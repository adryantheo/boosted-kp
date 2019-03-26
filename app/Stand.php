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

    // public function ProductList(){

    //     $products = [];

    //     foreach ($this->Products as $product){

    //         $products[]= $product->with([
    //         ])
    //         ->get();
        
    //     }
    //     return $products;

    // }
}



// public function outletList()
//     {
//         $outlets = [];

//         foreach ($this->outlets as $outlet) {
//             $outlets[] = $outlet->with(['addons:outlet_id,addon_id,status', 'addons.addon:id,name', 'cashiers:id,name,pin,outlet_id', 'outletType:id,name'])
//                             ->where('id', '=', $outlet->id)
//                             ->select('id', 'name', 'alias', 'address', 'logo', 'footer', 'contact', 'tagline', 'prefix', 'start_subscription', 'end_subscription', 'outlet_type_id')
//                             ->first();
//         }

//         return $outlets;
//     }