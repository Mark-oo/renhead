<?php

namespace App\Http\Services;

use App\PaymentApproval;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalService
{

    public function setToPending($approver,$data)
    {

            $data = [
                "user_id" => $approver,
                "payment_id" => $data['payment_id'],
                "payment_type" =>  $data['type_id'],
                "status" => "PENDING",
                'created_at' => now(),
                'updated_at' => now(),
            ];

        PaymentApproval::insert($data);
    }

    public function sumForUser($user)
    {
       $sum =  PaymentApproval::sum($user);

        return $sum;
    }

}
