<?php

namespace Kernel\Application\Session;

trait CSRFTrait
{
    /**
     * @var string The CSRF token used for form submission security.
     */
    protected string $csrfToken = '';

    /**
     * Sets the CSRF token.
     *
     * This method stores a CSRF token that can be used for verifying
     * the authenticity of requests coming from forms on the client-side.
     *
     * @param  string  $csrfToken  The CSRF token to be stored.
     */
    public function setCsrfToken(string $csrfToken): void
    {
        $this->csrfToken = $csrfToken;
    }

    /**
     * Gets the CSRF token.
     *
     * This method retrieves the CSRF token for use in forms to prevent CSRF attacks.
     *
     * @return string The stored CSRF token.
     */
    public function getCsrfToken(): string
    {
        return $this->csrfToken ?? '';
    }
}
