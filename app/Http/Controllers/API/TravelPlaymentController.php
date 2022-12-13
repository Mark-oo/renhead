<?php

namespace App\Http\Controllers\API;

use App\Http\Services\TravelPaymentService;
use App\Http\Controllers\Controller;
use App\TravelPayment;

class TravelPlaymentController extends Controller
{
    public function show($id,TravelPaymentService $travelPaymentService)
    {
        $travel_payment = $travelPaymentService->findSinglePayment($id);

        if($travel_payment == null){
            return response()->json([
                'message' => "No Access",
                'travel_payment' => $travel_payment,
            ]);
        }else{
            return response()->json([
                'travel_payment' => $travel_payment,
            ]);
        }
    }


    public function showAll(TravelPaymentService $travelPaymentService)
    {
        $travel_payment = $travelPaymentService->getAllPayments();

            return response()->json([
                'travel_payment' => $travel_payment,
            ]);

    }

    public function create()
    {
        $payment = new TravelPayment();
        $payment->setValues();

        return response()->json([
            'message' => 'Travel Payment created',
        ]);
    }

    public function edit($id)
    {
        $payment  = TravelPayment::findOrFail($id);
        $payment->setValues();

        return response()->json([
            'message' => 'Travel Payment updated',
        ]);
    }

    public function destroy($id)
    {
        $payment = TravelPayment::findOrFail($id);
        $payment->delete();

        return response()->json([
            'message' => 'Travel Payment deleted',
        ]);
    }
}
