<?php

namespace Kernel\Application\Http;

use Kernel\Application\Session\ValidationErrorsTrait;
use Kernel\Application\Validation\Validation;
use Kernel\Application\Validation\Validator\Validator;

/**
 * Class Request
 *
 * Represents an HTTP request, providing access to GET, POST, FILES, SERVER, and COOKIE data.
 * It supports data validation, input retrieval, flash messages, and sessions-based old input flashing.
 */
class Request
{
    private array $getData;

    private array $postParam;

    private array $files;

    private array $server;

    private array $cookies;

    /**
     * Request constructor.
     *
     * Initializes the request object with the given GET, POST, FILES, SERVER, and COOKIE data.
     * If the method is POST, it flashes old data into the session.
     *
     * @param  array  $getData  The GET parameters.
     * @param  array  $postParam  The POST parameters.
     * @param  array  $files  The file data from the request.
     * @param  array  $server  The server data from the request.
     * @param  array  $cookies  The cookies sent in the request.
     */
    public function __construct(
        array $getData = [],
        array $postParam = [],
        array $files = [],
        array $server = [],
        array $cookies = []
    ) {
        $this->getData = $getData;
        $this->postParam = $postParam;
        $this->files = $files;
        $this->server = $server;
        $this->cookies = $cookies;

        if ($this->method() === 'POST') {
            $this->flashOldData();
        }
    }

    /**
     * Creates an instance of the Request class using PHP's global variables.
     *
     * @return Request A new instance of the Request class.
     */
    public static function createFromGlobals(): Request
    {
        return new self(
            $_GET,
            $_POST,
            $_FILES,
            $_SERVER,
            $_COOKIE
        );
    }

    /**
     * Retrieves basic information about the request such as URI and method.
     *
     * @return array An associative array containing the request's URI and method.
     */
    public function getRequestInfo(): array
    {
        return [
            'uri' => $this->uri(),
            'method' => $this->method(),
        ];
    }

    /**
     * Returns the URI of the request.
     *
     * @return string The URI from the server data.
     */
    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '';
    }

    /**
     * Returns the HTTP request method (e.g., GET, POST).
     *
     * @return string The HTTP method of the request.
     */
    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Retrieves the input data (GET, POST, or old session data) for a given key.
     * If the key is not provided, it returns a merged array of GET and POST data.
     *
     * @param  string|null  $key  The input key to retrieve.
     * @return mixed The input data, or null if the key is not found.
     */
    public function input(?string $key = null): mixed
    {
        if ($key) {
            return $this->postParam[$key] ?? $this->getData[$key] ?? $this->old($key) ?? null;
        }

        return array_merge($this->getData, $this->postParam);
    }

    /**
     * Validates the input data based on the provided rules.
     *
     * @param  array  $rules  An array of validation rules.
     * @return array An array containing validation errors (if any).
     */
    public function validate(array $rules): array
    {
        $validator = new Validator;
        $validation = new Validation($validator);

        return $validation->validate($rules, $this->input());
    }

    /**
     * Merges additional data with the GET parameters.
     *
     * @param  array  $data  The data to merge with the GET parameters.
     */
    public function merge(array $data): void
    {
        $this->getData = array_merge($this->getData, $data);
    }

    /**
     * Retrieves all data from the request, including GET, POST, and session data.
     *
     * @return array An associative array containing all GET, POST, and session data.
     */
    public function all(): array
    {
        return [
            'get' => $this->getData,
            'post' => $this->postParam,
            'sessions' => session(),
        ];
    }

    /**
     * Retrieves a file from the request.
     *
     * @param  string  $key  The key for the file in the request.
     * @return mixed The file data, or null if not found.
     */
    public function file(string $key): mixed
    {
        return $this->files[$key] ?? null;
    }

    /**
     * Retrieves a cookie from the request.
     *
     * @param  string  $key  The key for the cookie.
     * @return mixed The cookie data, or null if not found.
     */
    public function cookie(string $key): mixed
    {
        return $this->cookies[$key] ?? null;
    }

    /**
     * Flashes the old POST data into the session, so it can be retrieved later.
     */
    private function flashOldData(): void
    {
        foreach ($this->postParam as $key => $value) {
            session()->setOld($key, $value);
        }
    }

    /**
     * Retrieves old data from the session.
     *
     * @param  string|null  $key  The key for the old data.
     * @return mixed The old data, or an empty string if not found.
     */
    public function old(?string $key = null): mixed
    {
        if ($key) {
            return session()->getOld($key);
        }

        return '';
    }

    /**
     * Checks if a given input parameter exists in the request (either GET or POST).
     *
     * @param  string  $key  The key to check.
     * @return bool True if the parameter exists, false otherwise.
     */
    public function has(string $key): bool
    {
        return isset($this->postParam[$key]) || isset($this->getData[$key]);
    }

    /**
     * Checks if a file exists in the request.
     *
     * @param  string  $key  The key for the file.
     * @return bool True if the file exists, false otherwise.
     */
    public function hasFile(string $key): bool
    {
        return isset($this->files[$key]) && is_uploaded_file($this->files[$key]['tmp_name']);
    }

    /**
     * Returns the IP address of the client.
     *
     * @return string The client's IP address.
     */
    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    /**
     * Returns the User-Agent of the client.
     *
     * @return string The client's User-Agent.
     */
    public function userAgent(): string
    {
        return $this->server['HTTP_USER_AGENT'] ?? '';
    }

    /**
     * Returns the referer URL, or a default fallback.
     *
     * @return string The referer URL, or '/' if not available.
     */
    public function back(): string
    {
        return $this->server['HTTP_REFERER'] ?? '/';
    }

    /**
     * Retrieves the query parameters from the URL (GET parameters).
     *
     * @return array An associative array of GET parameters.
     */
    public function getQueryParams(): array
    {
        return $_GET; // Standard way to get parameters
    }

    /**
     * Retrieves a specific query parameter from the URL (GET).
     *
     * @param  string  $key  The key for the GET parameter.
     * @param  mixed  $default  The default value to return if the parameter is not found.
     * @return mixed The value of the GET parameter, or the default value.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }
}
