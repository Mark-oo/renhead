<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use LDAP\Result;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const TYPE = [
         1 => 'APPROVER',
         2 => 'NOBODY'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'type', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function travel_payments()
    {
        return $this->hasMany(TravelPayment::class);
    }

    public static function validateNewUser($request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'type'=> 'required|numeric|in:'.implode(',',array_keys(self::TYPE)),
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|max:40|confirmed'
        ]);

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->type = self::TYPE[$request['type']];
        $user->email = $request['email'];
        $user->password =  Hash::make($request['password']);


        $user->save();

        $token = $user->createToken('auth')->plainTextToken;

        return $token;
    }

    public static function checkIfUserExist($email, $password)
    {
        $user = self::where('email', $email)
            ->first();

        if ($user && !Hash::check($password, $user->password)) {
            return null;
        }
        return $user;
    }

    public static function login()
    {
        $request = request();
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|max:40'
        ]);

        $user = self::checkIfUserExist($request['email'], $request['password']);

        return $user;
    }


    public static function logout()
    {
        auth()->user()->tokens()->delete();
    }

    public function getType()
    {
        return self::TYPE[$this->status];
    }

 
}
