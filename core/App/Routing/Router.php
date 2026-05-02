<?php

namespace Kernel\Application\Routing;

use Exception;
use Kernel\Application\Http\Request;
use Kernel\Application\Http\Response;

class Router
{
    private array $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'PATCH'  => [],
        'DELETE' => [],
    ];

    /**
     * @throws Exception
     */
    public function dispatch(array $routes, array $requestInfo, Request $request, Response $response): void
    {
        $this->distributeRoutes($routes);

        $method = $requestInfo['method'];
        $uri = strtok($requestInfo['uri'], '?');

        // Support method override via POST _method field (for HTML forms)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $override = strtoupper($_POST['_method']);
            if (in_array($override, ['PUT', 'PATCH', 'DELETE'], true)) {
                $method = $override;
            }
        }

        $available = $this->routes[$method] ?? [];

        foreach ($available as $route) {
            $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $route->uri());
            $pattern = '/^'.str_replace('/', '\/', $pattern).'$/';

            if (! preg_match($pattern, $uri, $matches)) {
                continue;
            }

            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            $request->merge($params);
            $request->merge($request->getQueryParams());

            foreach ($route->getMiddleware() as $middlewareClass) {
                $middleware = new $middlewareClass;
                $result = $middleware->handle($request, $response);
                if ($result === false) {
                    return;
                }
            }

            if (is_array($route->handler())) {
                [$controller, $action] = $route->handler();
                $content = call_user_func([new $controller, $action], $request);
            } else {
                $content = call_user_func($route->handler(), $request);
            }

            $response->setContent($content);
            return;
        }

        abort(404, 'Page not found');
    }

    public function generateUrlFromNameRoute(string $name, array $params = []): string
    {
        foreach (Route::getRoutes() as $route) {
            if ($route->getName() !== $name) {
                continue;
            }

            $uri = $route->uri();

            foreach ($params as $key => $value) {
                $uri = str_replace('{'.$key.'}', $value, $uri);
            }

            return $uri;
        }

        throw new Exception("Route [{$name}] not found.");
    }

    private function distributeRoutes(array $routes): void
    {
        foreach ($routes as $route) {
            $method = $route->method();
            if (isset($this->routes[$method])) {
                $this->routes[$method][] = $route;
            }
        }
    }
}
