<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function random()
    {
        return response()->json(Brand::with('Products')->inRandomOrder()->take(3)->get(),200);
    }
   
    public function index()
    {
        return response()->json(
            Brand::with([
                'Products'
            ])
            ->get(),200);
    }

    
    public function store(Request $request)
    {
        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            
                       
        ]);

        return response()->json([
            'status' => (bool) $brand,
            'data'   => $brand,
            'message' => $brand ? 'Brand Created!' : 'Error Creating Brand'
        ]);
    }

    
    public function show(Brand $brand)
    {
        
        return response()-> json(Brand::with('Products')->where('id', '=', $brand->id)->first(),200);                
    }

    public function update(Request $request, Brand $brand)
    {
        $status = $brand->update(
            $request->only(['name', 'description'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Brand Updated!' : 'Error Updating Brand'
        ]);
    }


    
    public function destroy(Brand $brand)
    {
        $status = $brand->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Brand Deleted!' : 'Error Deleting Brand'
            ]);
    }
}
