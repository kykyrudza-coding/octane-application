<?php

namespace Kernel\Application\Auth\AuthManager;

use App\Model\User;
use Kernel\Application\Session\Session;

class AuthManager
{
    public function __construct(
        private Session $session,
        private string $userModel = User::class
    ) {}

    public function login(array $credentials): bool
    {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (! $email || ! $password) {
            return false;
        }

        $model = $this->userModel;
        $user = $model::where(['email' => $email])->first();

        if (! $user || ! password_verify($password, $user->password)) {
            return false;
        }

        $userData = $user->attributes();
        unset($userData['password']);

        $this->session->setIsLogin(true);
        $this->session->setUser($userData);

        return true;
    }

    public function logout(): void
    {
        $this->session->setIsLogin(false);
        $this->session->setUser([]);
        $this->session->destroySession();
    }

    public function check(): bool
    {
        return $this->session->getIsLogin();
    }

    public function user(): ?array
    {
        $user = $this->session->getUser();

        return empty($user) ? null : $user;
    }
}
