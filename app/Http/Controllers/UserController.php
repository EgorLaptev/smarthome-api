<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function login(LoginUserRequest $request)
    {

        $credentials = $request->safe()->only('login', 'password');

        $attempt = Auth::attempt($credentials);

        if ($attempt) {

            $user = Auth::user();

            if (!$user['token']) {
                $user->token = Str::random(32);
                $user->save();
            }

            return response([
                'token' => Auth::user()['token']
            ], 200);

        }

        return response([
            'errors' => [
               'login' => ['Invalid credentials']
            ]
        ]);

    }

}
