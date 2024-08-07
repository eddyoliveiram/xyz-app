<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
    public function findByLogin(string $login): ?User
    {
        return User::where('login', $login)->first();
    }

    public function createToken(User $user): string
    {
        return $user->createToken('UserToken')->plainTextToken;
    }
}
