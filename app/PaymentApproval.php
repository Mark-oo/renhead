<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentApproval extends Model
{
    use SoftDeletes;

    protected $table = 'payment_approvals';
    protected $fillable = ['status'];
    public $timestamps = true;

    public static function sum($user)
    {

        // $data = 
        //     DB::select(
        //         DB::raw("SELECT coalesce(p.total_amount,tp.amount) as sumval
        //                  FROM payment_approvals AS pa
        //                  LEFT JOIN payments AS p ON p.id = pa.payment_id 
        //                  LEFT JOIN travel_payments AS tp ON tp.id = pa.payment_id 
        //                  WHERE pa.user_id = :user
        //                  GROUP BY pa.payment_id"),
        //                 ["user" => $user]
        //     );

        $data = DB::table('payment_approvals') 
                    ->leftJoin('payments', 'payments.id', '=', 'payment_approvals.payment_id')
                    ->leftJoin('travel_payments', 'travel_payments.id', '=', 'payment_approvals.payment_id')
                    ->where('payment_approvals.user_id','=',$user)
                    ->groupBy('payment_id')
                    ->selectRaw('coalesce(payments.total_amount,travel_payments.amount) as sum_val')
                    ->get()
                    ->sum('sum_val'); 

        return $data;
    }
}
