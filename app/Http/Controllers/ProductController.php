<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductController extends Controller
{
  
    
    public function random()
    {
        return response()->json(Product::inRandomOrder()->take(3)->get(),200);
    }

    public function index()
    {
        return response()->json(Product::all(),200);
    }

    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'units' => $request->units,
            'price' => $request->price,
            'size' => $request->size,
            'gender' => $request->gender,
            'image' => $this->uploadImage($request),
            'brand_id' => $request->brand_id
            
            
        ]);

        return response()->json([
            'status' => (bool) $product,
            'data'   => $product,
            'message' => $product ? 'Product Created!' : 'Error Creating Product'
        ]);
    }

    public function uploadImage(Request $request, $name = null)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');

            if (is_null($name)) {
                $name = time() . "_" . rand(1000, 1000000) . "." . $image->getClientOriginalExtension();
            }

            $image->move(public_path('storage/product'), $name);

            return '/storage/product/'.$name;
        }

        return '';
    }

    public function show(Product $product)
    {
        return response()-> json($product,200);
    }

    public function update(Request $request, Product $product)
    {
        

        $status = Product::find($product);
        $status->name = $request['name'];
        $status->description = $request['description'];
        $status->units = $request['units'];
        $status->price = $request['price'];
        $status->size = $request['size'];
        $status->gender = $request['gender'];
        $status->brand_id = $request['brand_id'];
        $status->image= $this->uploadImage($request);
        $status->update();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Updated!' : 'Error Updating Product'
        ], 200);

       
    }

  
    public function destroy(Product $product)
    {
        $status = $product->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
        ], 200);
    }
}
