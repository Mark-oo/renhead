<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Payment;
use App\Http\Services\PaymentService;


class PaymentController extends Controller
{

    public function show($id,PaymentService $paymentService)
    {
        $payment = $paymentService->findSinglePayment($id);

        if($payment == null){
            return response()->json([
                'message' => "No Acces",
                'payment' => $payment,
            ]);
        }else{
            return response()->json([
                'payment' => $payment,
            ]);
        }

    }

    public function showAll(PaymentService $paymentService)
    {
        $payments = $paymentService->getAllPayments();

            return response()->json([
                'payments' => $payments,
            ]);

    }

    public function create()
    {
        $payment = new Payment();
        $payment->setValues();

        return response()->json([
            'message' => 'Payment created',
        ]);
    }

    public function edit($id,PaymentService $paymentService)
    {  
        $payment = $paymentService->updatePayment($id);

        return response()->json([
            'message' => 'Payment updated',
        ]);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted',
        ]);
    }
}
