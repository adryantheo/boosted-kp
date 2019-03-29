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

    /**
     * Retrieve list of all transactions.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Nota::all(),200);
    }

    /**
     * Store a new transaction to storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $nota = null;

        DB::transaction(function () use ($request, &$nota) {
            //Creating a new transaction
            $nota = Nota::create([
                'harga_total' => $request->input('harga_total'),
                'customer' => $request->input('customer')
            ]);

            //Creating order details
            foreach ($request->input('products') as $product) {
                Order::create([
                    'product_id' => $product['product_id'],
                    'harga_satuan' => $product['harga_satuan'],
                    'quantity' => $product['quantity'],
                    'nota_id' => $nota->id
                ]);
            }
        }, 3);

        return response()->json([
            'status' => (bool) $nota,
            'nota_id'   => $nota ? $nota->id : null,
            'message' => $nota ? 'Nota Created!' : 'Error Creating Nota'
        ]);
    }

    /**
     * Get a transaction detail from storage.
     *
     * @param Nota $nota
     * @return JsonResponse
     */
    public function show(Nota $nota)
    {
        return response()->json($nota::with('Order')->where('id', '=', $nota->id)->first());     
    }

    /**
     * Update a transaction from storage.
     *
     * @param Request $request
     * @param Nota $nota
     * @return JsonResponse
     */
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

    /**
     * Delete a transaction from storage.
     *
     * @param Nota $nota
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Nota $nota)
    {
        $status = $nota->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Nota Deleted!' : 'Error Deleting Nota'
        ]);
    }
}
