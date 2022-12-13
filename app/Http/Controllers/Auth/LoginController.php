<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    public function register(Request $reqeust)
    {
        $new_user = User::validateNewUser($reqeust);

        return response()->json([
            'message' => 'Successful registration',
            "token" => $new_user
        ]);
    }

    public function login()
    {
        $user = User::login();

        if ($user === null) {
            return response()->json([
                'message' => 'Unsuccessful login',
            ]);
        } else {
            $token = $user->createToken('auth')->plainTextToken;

            return response()->json([
                'message' => 'Successful login',
                "token" => $token
            ]);
        }
    }

    public function logout()
    {
        User::logout();

        return response()->json([
            'message' => 'Successful logout',
        ]);
    }
}
