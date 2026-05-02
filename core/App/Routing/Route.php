<?php

namespace Kernel\Application\Routing;

use Closure;

/**
 * Class Route
 *
 * The Route class is responsible for defining and managing the application's routes.
 * It allows defining routes for different HTTP methods (GET, POST, etc.),
 * associating them with handlers (such as closures or controllers), and storing them
 * for later dispatching by the Router.
 */
class Route extends RouteConfig
{
    /**
     * @var RouteConfig[] Stores all registered routes.
     */
    private static array $routes = [];

    /**
     * Defines a GET route.
     *
     * This method is used to define a route for the GET HTTP method,
     * associating a URI pattern with a handler (closure or array).
     *
     * @param  string  $uri  The URI pattern for the route.
     * @param  Closure|array  $handler  The handler for the route (could be a closure or controller action).
     * @return RouteConfig The route configuration object.
     */
    public static function get(string $uri, Closure|array $handler): RouteConfig
    {
        return self::addRoute('GET', $uri, $handler);
    }

    /**
     * Defines a POST route.
     *
     * This method is used to define a route for the POST HTTP method,
     * associating a URI pattern with a handler (closure or array).
     *
     * @param  string  $uri  The URI pattern for the route.
     * @param  Closure|array  $handler  The handler for the route (could be a closure or controller action).
     * @return RouteConfig The route configuration object.
     */
    public static function post(string $uri, Closure|array $handler): RouteConfig
    {
        return self::addRoute('POST', $uri, $handler);
    }

    public static function put(string $uri, Closure|array $handler): RouteConfig
    {
        return self::addRoute('PUT', $uri, $handler);
    }

    public static function patch(string $uri, Closure|array $handler): RouteConfig
    {
        return self::addRoute('PATCH', $uri, $handler);
    }

    public static function delete(string $uri, Closure|array $handler): RouteConfig
    {
        return self::addRoute('DELETE', $uri, $handler);
    }

    /**
     * Adds a new route.
     *
     * This method is responsible for adding a route for a given HTTP method,
     * URI pattern, and handler. It stores the route in the static $routes array.
     *
     * @param  string  $method  The HTTP method (GET, POST, etc.).
     * @param  string  $uri  The URI pattern for the route.
     * @param  Closure|array  $handler  The handler for the route (could be a closure or controller action).
     * @return RouteConfig The route configuration object.
     */
    public static function addRoute(string $method, string $uri, Closure|array $handler): RouteConfig
    {
        $route = new RouteConfig($method, $uri, $handler);
        self::$routes[] = $route;

        return $route;
    }

    /**
     * Retrieves all registered routes.
     *
     * This method returns an array of all the routes that have been defined
     * using the `get` or `post` methods.
     *
     * @return RouteConfig[] The array of registered routes.
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
