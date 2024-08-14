<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\AuthRepository;
use App\Traits\ServiceResponser;
use LaravelEasyRepository\Service;

class AuthServiceImplement extends Service implements AuthService
{
    use ServiceResponser;

    /**
     * don't change $this->mainRepository variable name
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
