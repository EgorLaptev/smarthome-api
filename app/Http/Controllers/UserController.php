<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(LoginUserRequest $request)
    {

        $credentials = $request->safe()->only('login', 'password');

        $attempt = Auth::attempt($credentials);

        return $attempt
            ? response([
                'data' => [
                    'token' => Auth::user()['token']
                ]
            ], 200)
            : response([
                'errors' => [
                   'login' => ['Invalid credentials']
                ]
            ]);

    }

}
