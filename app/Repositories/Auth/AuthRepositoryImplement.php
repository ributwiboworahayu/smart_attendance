<?php

namespace App\Repositories\Auth;

use App\Models\OauthClient;
use App\Models\User;
use App\Traits\RepositoryResponser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use LaravelEasyRepository\Implementations\Eloquent;

class AuthRepositoryImplement extends Eloquent implements AuthRepository
{
    use RepositoryResponser;

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected OauthClient $model;

    public function __construct(OauthClient $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $payload
     * @return array
     */
    public function login(array $payload): array
    {
        // set type for login
        $type = 'login';

        // check if payload has email and password
        if (empty($payload['email']) || empty($payload['password'])) return self::result(error: true, message: 'Email and password are required');

        $attempt = [
            'email' => $payload['email'],
            'password' => $payload['password']
        ];
        $auth = Auth::attempt($attempt);
        if (!$auth) return self::result(error: true, message: 'Invalid credentials');

        // check if role has user role
        $hasUserRole = Auth::user()->whereHas('roles', function ($query) {
            $query->where('key', 'user');
        })->exists();
        if (!$hasUserRole) return self::result(error: true, message: 'You are not authorized to login');

        // check if already logged in two devices
        $countToken = Token::where('user_id', Auth::id())->where('revoked', 0)
            ->where('expires_at', '>', Carbon::now())->count();
        if ($countToken >= 2) return self::result(error: true, message: 'You are already logged in two devices');

        $clientId = env('CLIENT_SECRET_ID', 2);
        $secretClient = $this->model->find($clientId)->secret;

        return $this->extracted($type, $clientId, $secretClient, $payload);
    }

    public function refreshToken(array $payload): array
    {
        $clientId = env('CLIENT_SECRET_ID', 2);
        $secretClient = $this->model->find($clientId)->secret;

        $type = 'refresh-token';
        return $this->extracted($type, $clientId, $secretClient, $payload);
    }

    /**
     * @param string $type
     * @param mixed $clientId
     * @param $secretClient
     * @param array $payload
     * @return array
     */
    public function extracted(string $type, mixed $clientId, $secretClient, array $payload): array
    {
        $payload = match ($type) {
            'login' => [
                'client_id' => $clientId,
                'client_secret' => $secretClient,
                'grant_type' => 'password',
                'username' => $payload['email'],
                'password' => $payload['password'],
                'scope' => ''
            ],
            'refresh-token' => [
                'client_id' => $clientId,
                'client_secret' => $secretClient,
                'grant_type' => 'refresh_token',
                'refresh_token' => $payload['refresh_token'],
                'scope' => ''
            ],
        };

        $result = Http::asForm()->post(env('APP_URL') . 'oauth/token', $payload);
        if ($result->failed()) return self::result(error: true, data: $result->json(), message: 'Invalid credentials');
        return self::result(data: $result->json(), message: 'Login success');
    }

    /**
     * @param User $user
     * @return array
     */
    public function logout(User $user): array
    {
        // revoke token and refresh token
        $token = $user->token();
        $revokeRefreshToken = RefreshToken::where('access_token_id', $token->id)->update(['revoked' => true]);
        $revokeAccessToken = $token->revoke();
        $revoke = $revokeRefreshToken && $revokeAccessToken;

        if (!$revoke) return self::result(error: true, message: 'Failed to logout');
        return self::result(message: 'Successfully logged out');
    }
}
