<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::all();
        return response()->json(['data' => $payment]);
    }

    public function add_payment(Request $request)
    {
        $this->validate($request, [
            'total' => 'required'
        ]);

        $today = date('Ymd');
        $transactionCount = Payment::where('payment_number', 'like', $today . '%')->count();

        $paymentNumber = $today . '-' . str_pad($transactionCount + 1, 4, '0', STR_PAD_LEFT);

        $payment = new Payment;
        $payment->total = $request->total;
        $payment->payment_number = $paymentNumber;
        $payment->status = 'pending';
        $payment->save();
        $lastPaymentId = Payment::latest()->first()->id;

        return response()->json(['message' => 'Payment created', 'data' => $payment, 'payment_id' => $lastPaymentId], 201);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $this->validate($request, [
            'status' => 'required'
        ]);

        $payment->status = $request->status;
        $payment->save();

        return response()->json(['message' => 'Payment updated', 'data' => $payment], 200);
    }
}
