<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

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
            'id_payment' => 'required',
            'qty' => 'required'
        ]);

        $order = new Orders();
        $order->id_product = $request->id_product;
        $order->id_payment = $request->id_payment;
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
