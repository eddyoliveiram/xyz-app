<?php

namespace App\Repositories;

use App\Models\User;

interface AuthRepositoryInterface
{
    public function findByLogin(string $login): ?User;
    public function createToken(User $user): string;
}
