<?php

namespace Kernel\Application\Auth;

use Kernel\Application\Auth\AuthManager\AuthManager;
use Kernel\Application\Session\Session;

class Auth
{
    private AuthManager $authManager;

    public function __construct(Session $session)
    {
        $this->authManager = new AuthManager($session);
    }

    public function user(): ?array
    {
        return $this->authManager->user();
    }

    public function check(): bool
    {
        return $this->authManager->check();
    }

    public function logout(): void
    {
        $this->authManager->logout();
    }

    public function login(array $credentials): bool
    {
        return $this->authManager->login($credentials);
    }
}
