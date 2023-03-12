<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Orders::all();
        return response()->json(['data' => $orders]);
    }

    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['data' => $order]);
    }

    public function add_order(Request $request)
    {
        $this->validate($request, [
            'id_product' => 'required',
            // 'id_payment' => 'required',
            'qty' => 'required'
        ]);

        try {
            $product_response = Http::get('http://localhost:8000/api/v1/products/' . $request->id_product)->json();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error accessing product service'], 500);
        }

        $total = $product_response['data']['price'] * $request->qty;

        try {
            $payment_response = Http::post('http://localhost:8002/api/v1/payment/', [
                'total' => $total
            ])->json();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error accessing payment service'], 500);
        }

        try {
            $stock = Http::get('http://localhost:8000/api/v1/products/' . $request->id_product)->json();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error accessing product service'], 500);
        }

        $count = $stock['data']['stock'] - $request->qty;

        try {
            $product_update_response = Http::post('http://localhost:8000/api/v1/products/update/' . $request->id_product, [
                'stock' => $count
            ])->json();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating product'], 500);
        }

        $payment_id = $payment_response['payment_id'];

        $order = new Orders();
        $order->id_product = $request->id_product;
        $order->id_payment = $payment_id;
        $order->qty = $request->qty;
        $order->save();

        return response()->json(['message' => 'Order created', 'data' => $order], 201);
    }

    public function update(Request $request, $id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $this->validate($request, [
            'id_product' => 'required',
            'id_payment' => 'required',
            'qty' => 'required'
        ]);

        $order->id_product = $request->id_product;
        $order->id_payment = $request->id_payment;
        $order->qty = $request->qty;
        $order->save();

        return response()->json(['message' => 'Product updated', 'data' => $order], 200);
    }

    public function delete($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted'], 200);
    }
}
