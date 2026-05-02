<?php

namespace Kernel\Application\Routing;

use Closure;

/**
 * Class RouteConfig
 *
 * The RouteConfig class is responsible for configuring a specific route,
 * including the HTTP method, URI pattern, handler (closure or array),
 * and optional route properties such as middleware and name.
 * This class is used to define routes and their associated attributes in the application.
 */
class RouteConfig
{
    /**
     * @var string The HTTP method (e.g., GET, POST).
     */
    private string $method;

    /**
     * @var string The URI pattern for the route.
     */
    private string $uri;

    /**
     * @var Closure|array The handler for the route, can be a closure or an array (controller action).
     */
    private Closure|array $handler;

    /**
     * @var string|null The name of the route (optional).
     */
    private ?string $name = null;

    /**
     * @var array The middleware associated with the route.
     */
    private array $middleware = [];

    /**
     * RouteConfig constructor.
     *
     * @param  string  $method  The HTTP method (e.g., GET, POST).
     * @param  string  $uri  The URI pattern for the route.
     * @param  Closure|array  $handler  The handler for the route (can be a closure or controller action).
     */
    public function __construct(string $method, string $uri, Closure|array $handler)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
    }

    /**
     * Defines middleware for the route.
     *
     * This method associates middleware with the route. The middleware can be
     * passed as a string (single middleware) or an array (multiple middleware).
     *
     * @param  string|array  $middleware  The middleware to associate with the route.
     * @return self The current RouteConfig instance (for method chaining).
     */
    public function middleware(string|array $middleware = []): self
    {
        if (is_array($middleware)) {
            $this->middleware = $middleware;
        } else {
            $this->middleware = [$middleware];
        }

        return $this;
    }

    /**
     * Sets the name of the route.
     *
     * This method assigns a name to the route, which can be used for reverse routing or URL generation.
     *
     * @param  string  $name  The name to assign to the route.
     * @return self The current RouteConfig instance (for method chaining).
     */
    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the HTTP method of the route.
     *
     * @return string The HTTP method (e.g., GET, POST).
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Gets the URI pattern of the route.
     *
     * @return string The URI pattern for the route.
     */
    public function uri(): string
    {
        return $this->uri;
    }

    /**
     * Gets the middleware associated with the route.
     *
     * @return array An array of middleware associated with the route.
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * Gets the handler for the route.
     *
     * @return Closure|array The handler (closure or array) associated with the route.
     */
    public function handler(): Closure|array
    {
        return $this->handler;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
