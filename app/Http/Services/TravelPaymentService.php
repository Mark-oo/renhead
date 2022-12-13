<?php

namespace App\Http\Services;

use App\TravelPayment;
use Illuminate\Support\Facades\Auth;

class TravelPaymentService
{

    public function checkIfHasAcces($travel_payment, $user)
    {

        if ($user->type == "APPROVER" || $user->id == $travel_payment->user_id) {
            return true;
        } else {
            return false;
        }
    }

    public function findSinglePayment($id)
    {
        $travel_payment = TravelPayment::find($id);

        $access = self::checkIfHasAcces($travel_payment, Auth::user());
        if ($access) {
            return  $travel_payment;
        } else {
            return null;
        }
    }

    public function getAllPayments()
    {   
        $user = Auth::user();
        if($user->type == "APPROVER"){
            $travel_payment = TravelPayment::all();
            return $travel_payment;
        }else{
            $travel_payment = TravelPayment::where('user_id',$user->id)->get();
            return $travel_payment;
        }
    }
}
