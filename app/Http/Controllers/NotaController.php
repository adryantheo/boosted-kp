<?php

namespace App\Http\Controllers;

use App\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
   
    public function index()
    {
        return response()->json(Nota::all(),200);
    }

    
    public function store(Request $request)
    {
        $nota = Nota::create([
            
            'harga_total' => $request->harga_total
            
        ]);

        return response()->json([
            'status' => (bool) $nota,
            'data'   => $nota,
            'message' => $nota ? 'Nota Created!' : 'Error Creating Nota'
        ]);
    }

    
    public function show(Nota $nota)
    {
        return response()->json($nota::with('order')->where('id', '=', $nota->id)->first());     
    }

   
    public function update(Request $request, Nota $nota)
    {
        $status = $nota->update(
            $request->only([ 'harga_total'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Nota Updated!' : 'Error Updating Nota'
        ]);
    }

   
    public function destroy(Nota $nota)
    {
        $status = $nota->delete();

            return response()->json([
                'status' => $status,
                'message' => $status ? 'Nota Deleted!' : 'Error Deleting Nota'
            ]);
    }
}
