<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->has('stand')) {
            return response()->json(
                Order::with([
                    'Nota:id,customer',
                    'Product' => function($query) use ($request) {
                        $query->where('stand_id', '=', $request->input('stand'));
                        $query->select('id', 'name');
                    }
                ])->get()
            );
        }

        return response()->json(Order::with(['Nota:id,customer', 'Product:id,name'])->get(),200);
    }

    
    public function store(Request $request)
    {
        $order = Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'harga_satuan' => $request->harga_satuan,
            'nota_id' => $request->nota_id,
        ]);

        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    
    public function show(Order $order)
    {
        return response()->json($order,200);
    }

   
    public function update(Request $request, Order $order)
    {
        $status = $order->update(
            $request->only(['product_id','quantity','harga_satuan', 'nota_id'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

  
    public function destroy(Order $order)
    {
        $status = $order->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }
}
