<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->has('brand')) {
            return response()->json(
                Order::with([
                    'Nota:id,customer',
                    'Product'=> function($query) use ($request) {
                        
                        $query->where('brand_id', '=', $request->input('brand'));
                        $query->select('id', 'name');
                        $query->withTrashed();
                        
                    }
                ])->get()
            );
        }

        return response()->json(Order::with(['Nota:id,customer', 'Product:id,name'])->get(),200);
    }

    public function all()
    {
        return response()->json(Order::with([
            'Nota' => function($query)
            {
                $query->select('id','customer');
            },
            'Product'=> function($query){
                $query->withTrashed();
            },
            'Product.Brand'=>function($query){
                $query->withTrashed();
                $query->select('id', 'name');
            }
            
            ])->get(),200);
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
            $request->only(['is_paid','is_delivered'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    public function paid(Order $order)
    {
        $order->is_paid = true;
        $order->is_delivered = true;
        $status = $order->save();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    public function canceled(Order $order)
    {
       $order->is_paid = false;
       $order->is_delivered = false;
       $status = $order->save();

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
