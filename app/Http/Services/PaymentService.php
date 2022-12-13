<?php

namespace App\Http\Services;

use App\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentService
{

    public function checkIfHasAcces($payment, $user)
    {

        if ($user->type == "APPROVER" || $user->id == $payment->user_id) {
            return true;
        } else {
            return false;
        }
    }

    public function findSinglePayment($id)
    {
        $payment = Payment::find($id);

        $access = self::checkIfHasAcces($payment, Auth::user());
        if ($access) {
            return  $payment;
        } else {
            return null;
        }
    }

    public function getAllPayments()
    {   
        $user = Auth::user();
        if($user->type == "APPROVER"){
            $payments = Payment::all();
            return $payments;
        }else{
            $payments = Payment::where('user_id',$user->id)->get();
            return $payments;
        }
    }

    public function updatePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $access = self::checkIfHasAcces($payment, Auth::user());
        if ($access) {
            return  "Payment updated";
        } else {
            return  "Not authorised to updated this payment";
        }
    }
}
