<?php

namespace App\Services\Auth;

use App\Models\User;
use LaravelEasyRepository\BaseService;

interface AuthService extends BaseService
{

    public function login(array $payload): array;

    public function refreshToken(array $payload): array;

    public function logout(User $user);
}
