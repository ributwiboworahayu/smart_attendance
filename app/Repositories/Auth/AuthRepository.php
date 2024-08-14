<?php

namespace App\Repositories\Auth;

use App\Models\User;
use LaravelEasyRepository\Repository;

interface AuthRepository extends Repository
{

    public function login(array $payload): array;

    public function refreshToken(array $payload): array;

    public function logout(User $user);
}
