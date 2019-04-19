<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Order;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{

   
    public function index()
    {
        return response()->json(Nota::with(['Order', 'Order.Product:id,name'])->get(),200);
    }

   
    public function store(Request $request)
    {
        $nota = null;

        DB::transaction(function () use ($request, &$nota) {
            //Creating a new transaction
            $nota = Nota::create([
                'harga_total' => $request->input('harga_total'),
                'customer' => $request->input('customer'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ]);

            //Creating order details
            foreach ($request->input('products') as $detail) {
                Order::create([
                    'product_id' => $detail['product_id'],
                    'harga_satuan' => $detail['harga_satuan'],
                    'is_delivered' => $detail['is_delivered'],
                    'is_paid' => $detail['is_paid'],
                    'quantity' => $detail['quantity'],
                    'nota_id' => $nota->id,
                ]);

                $product = Product::find($detail['product_id']);
                $product->units -= $detail['quantity'];
                $product->save();
            }
        }, 3);

        return response()->json([
            'status' => (bool) $nota,
            'nota_id'   => $nota ? $nota->id : null,
            'message' => $nota ? 'Nota Created!' : 'Error Creating Nota'
        ]);
    }

  
    public function show(Nota $nota)
    {
        return response()->json(
            $nota::with([
                'Order',
                'Order.Product.Brand:id,name',                           
                ])
        ->where('id', '=', $nota->id)->first());
    }

   
    public function update(Request $request, Nota $nota)
    {
        $status = $nota->update(
            $request->only([ 'harga_total','phone','address','customer'])
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
