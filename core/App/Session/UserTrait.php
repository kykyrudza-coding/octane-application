<?php

namespace Kernel\Application\Session;

/**
 * Trait UserTrait
 *
 * This trait provides methods to manage user-related session data, including user
 * information and login status. It allows you to get and set user data, track login
 * status, and clear the user-related session data.
 */
trait UserTrait
{
    /**
     * Retrieves the user data stored in the session.
     *
     * @return array The user data.
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * Sets the user data in the session.
     *
     * @param  array  $user  The user data to set.
     */
    public function setUser(array $user): void
    {
        $this->user = $user;
        $this->saveDataToFile();
    }

    /**
     * Sets the login status of the user.
     *
     * @param  bool  $isLogin  The login status (true for logged in, false for logged out).
     */
    public function setIsLogin(bool $isLogin): void
    {
        $this->isLogin = $isLogin;
        $this->saveDataToFile();
    }

    /**
     * Retrieves the login status of the user.
     *
     * @return bool True if the user is logged in, false otherwise.
     */
    public function getIsLogin(): bool
    {
        return $this->isLogin;
    }

    /**
     * Destroys the user session data, effectively logging the user out.
     */
    public function destroy(): void
    {
        $this->user = [];
        $this->isLogin = false;
    }

    /**
     * Clears the user data and login status.
     */
    private function clearUser(): void
    {
        $this->user = [];
        $this->isLogin = false;
    }
}
