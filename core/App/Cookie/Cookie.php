<?php

namespace Kernel\Application\Cookie;

/**
 * Class Cookie
 *
 * This class provides methods for handling cookies, including setting, getting,
 * deleting, and sending cookies with various configuration options such as
 * expiration time, path, domain, security, and HTTP-only flags.
 */
class Cookie
{
    /**
     * @var string The name of the cookie.
     */
    private string $name;

    /**
     * @var array The value of the cookie.
     */
    private array $value;

    /**
     * @var int The expiration time of the cookie (Unix timestamp).
     */
    private int $expires;

    /**
     * @var string The path where the cookie is available.
     */
    private string $path;

    /**
     * @var string The domain for which the cookie is available.
     */
    private string $domain;

    /**
     * @var bool Indicates whether the cookie should only be sent over secure connections.
     */
    private bool $secure;

    /**
     * @var bool Indicates whether the cookie is accessible only through HTTP requests (not JavaScript).
     */
    private bool $httponly;

    /**
     * Cookie constructor.
     *
     * Initializes a cookie with the specified attributes.
     *
     * @param  string  $name  The name of the cookie.
     * @param  array  $value  The value of the cookie.
     * @param  int  $expires  The expiration time of the cookie (Unix timestamp). Default is 0 (session cookie).
     * @param  string  $path  The path where the cookie is available. Default is '/'.
     * @param  string  $domain  The domain for which the cookie is available. Default is ''.
     * @param  bool  $secure  Indicates whether the cookie should only be sent over secure connections. Default is false.
     * @param  bool  $httponly  Indicates whether the cookie is accessible only through HTTP requests. Default is false.
     */
    public function __construct(
        string $name,
        array $value,
        int $expires = 0,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httponly = false
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->expires = $expires;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httponly = $httponly;
    }

    /**
     * Get the name of the cookie.
     *
     * @return string The name of the cookie.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of the cookie.
     *
     * @return array The value of the cookie.
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * Get the expiration time of the cookie.
     *
     * @return int The expiration time of the cookie (Unix timestamp).
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    /**
     * Get the path where the cookie is available.
     *
     * @return string The path where the cookie is available.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the domain for which the cookie is available.
     *
     * @return string The domain for which the cookie is available.
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Check if the cookie is secure (only sent over HTTPS).
     *
     * @return bool True if the cookie is secure, false otherwise.
     */
    public function isSecure(): bool
    {
        return $this->secure;
    }

    /**
     * Check if the cookie is accessible only via HTTP (not JavaScript).
     *
     * @return bool True if the cookie is HTTP-only, false otherwise.
     */
    public function isHttponly(): bool
    {
        return $this->httponly;
    }

    /**
     * Set the name and value of the cookie.
     *
     * @param  string  $name  The new name of the cookie.
     * @param  array  $value  The new value of the cookie.
     */
    public function set(string $name, array $value): void
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get a specific value from the cookie.
     *
     * @param  string  $name  The key name of the value to retrieve from the cookie.
     * @return mixed|null The value associated with the key, or null if not set.
     */
    public function get(string $name): mixed
    {
        return $this->value[$name] ?? null;
    }

    /**
     * Delete the cookie by setting its expiration time to the past.
     */
    public function delete(): void
    {
        $this->expires = time() - 3600;
    }

    /**
     * Send the cookie to the browser.
     *
     * This method sends the cookie to the user's browser by calling the `setcookie` function.
     */
    public function send(): void
    {
        setcookie($this->name, $this->value, $this->expires, $this->path, $this->domain, $this->secure, $this->httponly);
    }
}
