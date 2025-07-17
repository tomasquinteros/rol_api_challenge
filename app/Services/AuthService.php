<?php

namespace App\Services;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function __construct(protected UserInterface $user)
    {
    }

    public function authenticate(array $credentials): array
    {
        $email = $credentials['email'];
        $password = $credentials['password'];

        $user = $this->user->getByEmail($email);
        if (!$user || !password_verify($password, $user->password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        $tokenResult = $this->createToken($user);
        return [
            'user' => $user,
            'token' => $tokenResult['token'],
            'token_id' => $tokenResult['token_id']
        ];
    }

    public function createToken(User $user): array
    {
        $token = $user->createToken('access_token');
        return [
            'token' => $token->plainTextToken,
            'token_id' => $token->accessToken->id,
            'token_name' => 'access_token',
        ];
    }

    /**
     * Logout user by revoking current token
     *
     * @param User $user
     * @return bool
     */
    public function logout(User $user): bool
    {
        $currentToken = $user->currentAccessToken();
        if ($currentToken) {
            $currentToken->delete();
            return true;
        }
        return false;
    }
    public function revokeTokensByUser(User $user): int
    {
        $tokenCount = $user->tokens()->count();
        $user->tokens()->delete();
        return $tokenCount;
    }
}
