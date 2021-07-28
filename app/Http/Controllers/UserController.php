<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function generateToken(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // return Auth::user();
            return Auth::user()->api_token;
        } else {
            return response()->json(["error" => "User Not found!!! Please try again!"], 404);
        }
    }
}
