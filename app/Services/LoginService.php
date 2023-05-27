<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    /**
     * method to autenticated the user
     *
     * @param [type] $data
     */
    public function login($data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new CustomException('Invalid email or password', 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }
}
