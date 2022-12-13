<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\PaymentApproval;
use App\Http\Services\ApprovalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{

    public function requestApproval(Request $request,ApprovalService $approvalService)
    {
        $data = $request->all();
        foreach ($data['approver_id'] as $approver) {
            $approvalService->setToPending($approver,$data);
        }

        return response()->json([
            'message' => 'Approval requested',
        ]);
}


    public function approvePayment($id)
    {
        $pending = PaymentApproval::where('id',$id)->where('user_id',Auth::id())->get();

        $pending->update([
            'status' => "APPROVED"
        ]);

        return response()->json([
            'message' => 'Approved',
        ]);
    }

    public function sumPayments(ApprovalService $approvalService)
    {
        $sum = $approvalService->sumForUser(Auth::id());

        return response()->json([
            'message' => 'Sum is '.$sum,
        ]);    
    }
}