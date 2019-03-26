<?php

namespace App\Http\Controllers;

use App\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function random()
    {
        return response()->json(Stand::inRandomOrder()->take(6)->get(),200);
    }
   
    public function index()
    {
        return response()->json(Stand::with('Products')->get(),200);
    }

    
    public function store(Request $request)
    {
        $stand = Stand::create([
            'name' => $request->name,
            'description' => $request->description,
            
                       
        ]);

        return response()->json([
            'status' => (bool) $stand,
            'data'   => $stand,
            'message' => $stand ? 'Stand Created!' : 'Error Creating Stand'
        ]);
    }

    
    public function show(Stand $stand)
    {
        return response()-> json(Stand::with('Products')->whereIn('id', $stand)->get(),200);                
    }

    public function update(Request $request, Stand $stand)
    {
        $status = $stand->update(
            $request->only(['name', 'description'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Stand Updated!' : 'Error Updating Stand'
        ]);
    }


    
    public function destroy(Stand $stand)
    {
        $status = $stand->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Stand Deleted!' : 'Error Deleting Stand'
            ]);
    }
}
