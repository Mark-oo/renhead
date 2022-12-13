<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TravelPayment extends Model
{
    use SoftDeletes;

    protected $table = 'travel_payments';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setValues()
    {   
        
        $request = request();

        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $this->user_id = Auth::id();
        $this->amount = $request['amount'];

        $this->save();
    }
}
