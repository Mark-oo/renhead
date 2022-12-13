<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    use SoftDeletes;

    protected $table = 'payments';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setValues()
    {   
        $request = request();

        $request->validate([
            'total_amount' => 'required|numeric',
        ]);
        $this->user_id = Auth::id();
        $this->total_amount = $request['total_amount'];

        $this->save();
    }
}
