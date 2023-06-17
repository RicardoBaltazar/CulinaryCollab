<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginService
{
    public function login(array $data): string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new CustomException('Invalid email or password', 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return $token;
    }

    public function logout($request): string
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return 'Logout realizado com sucesso.';

        } catch (\Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
}
