<?php

use Kernel\Application\Application;
use Kernel\Application\Configuration\Env;
use Kernel\Application\Http\Request;
use Kernel\Application\Http\Response;
use Kernel\Application\Session\Session;
use Kernel\Application\View\View;

/**
 * Helper function to trigger an abort with a given status code and message.
 *
 * @param int $code The HTTP status code (e.g., 404 for Not Found).
 * @param string $message The message to display along with the status code.
 *
 * @return Response The generated HTTP response.
 */
if (! function_exists('abort')) {
    function abort(int $code, string $message = ''): Response
    {
        global $app;
        $response = $app->get('response');

        return $response::abort($code, $message);
    }
}

/**
 * Helper function to get the current HTTP request.
 *
 * @return Request The current request instance.
 */
if (! function_exists('request')) {
    function request(): Request
    {
        global $app;

        return $app->get('request');
    }
}

/**
 * Helper function to get the current HTTP response.
 *
 * @return Response The current response instance.
 */
if (! function_exists('response')) {
    function response(): Response
    {
        global $app;

        return $app->get('response');
    }
}

/**
 * Helper function to render a view with optional data.
 *
 * @param string $view The name of the view to render.
 * @param mixed $data The data to pass to the view (optional).
 *
 * @return View The rendered view instance.
 */
if (! function_exists('view')) {
    function view(string $view, mixed $data = []): View
    {
        return (new View)->render($view, $data);
    }
}

/**
 * Helper function to get an environment variable.
 *
 * @param string $key The key of the environment variable.
 * @param mixed $default The default value to return if the variable is not set (optional).
 *
 * @return mixed The value of the environment variable or the default value.
 */
if (! function_exists('env')) {
    function env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}

/**
 * Helper function to generate a UUID (Universally Unique Identifier).
 *
 * @return string A generated UUID string.
 */
if (! function_exists('uuid')) {
    function uuid(): string
    {
        $uuid = bin2hex(random_bytes(12));
        if (! str_contains($uuid, '-')) {
            $uuidWithDash = '';
            for ($i = 0; $i < strlen($uuid); $i++) {
                if (($i + 1) % 5 === 0) {
                    $uuidWithDash .= '-';
                } else {
                    $uuidWithDash .= $uuid[$i];
                }
            }

            return $uuidWithDash;
        }

        return str_replace('-', '', $uuid);
    }
}

/**
 * Helper function to get the storage path for a given file or directory.
 *
 * @param string $path The relative path within the storage directory.
 *
 * @return string The full path to the file or directory within the storage folder.
 */
if (! function_exists('storage_path')) {
    function storage_path(string $path): string
    {
        return APP_ROOT.'/storage/'.$path;
    }
}

/**
 * Helper function to get the application path.
 *
 * @param string $path The relative path within the application directory.
 *
 * @return string The full path to the file or directory within the application folder.
 */
if (! function_exists('app_path')) {
    function app_path(string $path): string
    {
        return APP_ROOT.$path;
    }
}

/**
 * Helper function to get the path to the views folder.
 *
 * @param string $path The relative path within the views directory (optional).
 *
 * @return string The full path to the views directory or the requested view file.
 */
if (! function_exists('views_path')) {
    function views_path(string $path = ''): string
    {
        return APP_ROOT.'/resources/views/'.$path;
    }
}

/**
 * Helper function to retrieve configuration settings.
 *
 * @param string $key The key of the configuration setting.
 * @param mixed $default The default value to return if the setting is not found (optional).
 *
 * @return mixed The configuration value or the default value.
 */
if (! function_exists('config')) {
    function config(string $key, $default = null): array
    {
        global $app;

        return $app->get('config')->get($key) ?? $default;
    }
}

/**
 * Helper function to retrieve the session instance.
 *
 * @return Session The current session instance.
 */
if (! function_exists('session')) {
    function session(): Session
    {
        global $app;

        return $app->get('sessions');
    }
}

/**
 * Helper function to get the application instance.
 *
 * @return Application The current application instance.
 */
if (! function_exists('app')) {
    function app(): Application
    {
        global $app;

        return $app;
    }
}

/**
 * Helper function to generate a URL from a named route with optional parameters.
 *
 * @param string $name The name of the route.
 * @param array $params The parameters to pass to the route (optional).
 *
 * @return string The generated URL.
 */
if (! function_exists('route')) {
    function route(string $name, array $params = []): string
    {
        global $app;

        return $app->get('router')->generateUrlFromNameRoute($name, $params);
    }
}

/**
 * Helper function to perform a redirect to a given URI.
 *
 * @param string $uri The URI to redirect to.
 *
 * @return Response The response object for the redirect.
 */
if (! function_exists('redirect')) {
    function redirect(string $uri): Response
    {
        global $app;

        return $app->get('redirect')->redirect($uri);
    }
}

/**
 * Helper function to retrieve a validation error message for a specific field.
 *
 * @param string $name The name of the validation field.
 * @param array|null $errors The list of errors to check (optional).
 *
 * @return string|false The validation error message or false if not found.
 */
if (! function_exists('error')) {
    function error(string $name, ?array $errors = null): string|false
    {
        $message = session()->getValidationError($name, '');
        if (! empty($message)) {
            echo $message;
        }

        return false;
    }
}

/**
 * Helper function to check if a validation error exists for a specific field.
 *
 * @param string $name The name of the validation field.
 * @param string $default The default message if no error exists.
 * @param string $fail The message to display if an error exists.
 *
 * @return string The appropriate message based on the validation state.
 */
if (! function_exists('hasError')) {
    function hasError(string $name, string $default, string $fail): string
    {
        return session()->hasValidationError($name) ? $fail : $default;
    }
}

/**
 * Helper function to access the authentication service.
 *
 * @return mixed The authentication service instance.
 */
if (! function_exists('auth')) {
    function auth(): mixed
    {
        global $app;

        return $app->get('auth');
    }
}

/**
 * Helper function to access the cache service.
 *
 * @return mixed The cache service instance.
 */
if (! function_exists('cache')) {
    function cache(): mixed
    {
        global $app;

        return $app->get('cache');
    }
}
