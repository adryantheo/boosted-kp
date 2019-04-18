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
            'image' => $this->uploadImage($request),
        ]);

        return response()->json([
            'status' => (bool) $brand,
            'data'   => $brand,
            'message' => $brand ? 'Brand Created!' : 'Error Creating Brand'
        ]);
    }

    /**
     * Handle an image upload.
     *
     * @param Request $request
     * @param null $name
     * @return string
     */
    public function uploadImage(Request $request, $name = null)
    {
        if($request->hasFile('image')){
            $image = $request->file('image');

            if (is_null($name)) {
                $name = time() . "_" . rand(1000, 1000000) . "." . $image->getClientOriginalExtension();
            }

            $image->move(public_path('storage/brand'), $name);

            return '/storage/brand/'.$name;
        }

        return '';
    }
    
    public function show(Brand $brand)
    {
        
        return response()-> json(Brand::with('Products')->where('id', '=', $brand->id)->first(),200);                
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->only(['name', 'description']);
        
        $status = $brand->update($data);

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Brand Updated!' : 'Error Updating Brand'
        ], 200);
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
