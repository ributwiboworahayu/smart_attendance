<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use App\Traits\ServiceResponser;
use Illuminate\Support\Facades\Auth;
use LaravelEasyRepository\Service;

class AuthServiceImplement extends Service implements AuthService
{
    use ServiceResponser;

    /**
     * don't change $this→mainRepository variable name
     * because used in extends service class
     */
    protected AuthRepository $mainRepository;

    public function __construct(AuthRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * @param array $payload
     * @return array
     */
    public function login(array $payload): array
    {
        // check if payload has email and password
        if (empty($payload['email']) || empty($payload['password'])) return self::finalResultFail(message: 'Email and password are required');

        $attempt = [
            'email' => $payload['email'],
            'password' => $payload['password']
        ];
        $auth = Auth::attempt($attempt);
        if (!$auth) return self::finalResultFail(message: 'Invalid credentials');

        // check if role has user role
        $hasUserRole = User::where('email', $payload['email'])->whereHas('roles', function ($query) {
                $query->where('key', 'user');
            })->count() === 1;
        if (!$hasUserRole) return self::finalResultFail(message: 'You are not authorized to login');

        $result = $this->mainRepository->login($payload);
        if (!$result['error']) return self::finalResultFail($result['data'], $result['message']);
        return self::finalResultSuccess($result['data'], $result['message']);
    }

    /**
     * @param User $user
     * @return array
     */
    public function logout(User $user): array
    {
        $result = $this->mainRepository->logout($user);
        if (!$result['error']) return self::finalResultFail($result['data'], $result['message']);
        return self::finalResultSuccess($result['data'], $result['message']);
    }

    public function refreshToken(array $payload): array
    {
        $result = $this->mainRepository->refreshToken($payload);
        if (!$result['error']) return self::finalResultFail($result['data'], $result['message']);
        return self::finalResultSuccess($result['data'], $result['message']);
    }
}
