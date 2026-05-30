<?php

namespace Kernel\Application;

use Exception;
use Kernel\Application\Auth\Auth;
use Kernel\Application\Cache\Cache;
use Kernel\Application\Configuration\Config;
use Kernel\Application\Configuration\Env;
use Kernel\Application\Cookie\Cookie;
use Kernel\Application\DataBase\DB\DataBaseConnect;
use Kernel\Application\Errors\ErrorHandler;
use Kernel\Application\Http\Kernel;
use Kernel\Application\Http\Redirect;
use Kernel\Application\Http\Request;
use Kernel\Application\Http\Response;
use Kernel\Application\Routing\Router;
use Kernel\Application\Session\Session;
use Kernel\Application\Validation\Validation;
use Kernel\Application\Validation\Validator\Validator;
use Kernel\Application\View\View;

/**
 * The core Application class that handles the lifecycle of the application.
 *
 * This class initializes the environment, configures services, handles errors, and runs the HTTP kernel.
 */
class Application extends Container
{
    /**
     * Application constructor.
     *
     * @param  array  $services  Optional services to override default application services.
     */
    public function __construct(array $services = [])
    {
        $this->loadHelpers();
        parent::__construct($services);
    }

    /**
     * Runs the application.
     *
     * This method sets up the environment, error handling, services, and runs the HTTP kernel.
     *
     * @throws Exception If a required service or configuration is missing.
     */
    public function run(): void
    {
        $this->loadEnvironment();
        $this->setupErrorHandling();
        $this->registerServices();
        $this->initializeConfig();
        $this->get('database')->connect();
        $this->get('cache')->init();
        $this->createKernel()->run();
    }

    /**
     * Registers core services for the application.
     *
     * @throws Exception If required configuration or services are not available.
     */
    private function registerServices(): void
    {
        $config = new Config($this->loadConfig());
        $this->set('config', $config);
        $this->set('sessions', $this->services['sessions'] ?? new Session);
        $this->set('cookies', $this->services['cookies'] ?? new Cookie('Octane', ['path' => '/', 'secure' => false]));
        $this->set('cache', $this->services['cache'] ?? new Cache());
        $this->set('request', $this->services['request'] ?? Request::createFromGlobals());
        $this->set('response', $this->services['response'] ?? new Response);
        $this->set('router', $this->services['router'] ?? new Router);
        $this->set('redirect', $this->services['redirect'] ?? new Redirect);
        $this->set('view', $this->services['view'] ?? new View);
        $this->set('database', $this->services['database'] ?? new DataBaseConnect($this->get('config')));
        $this->set('validator', $this->services['validator'] ?? new Validator);
        $this->set('validation', $this->services['validation'] ?? new Validation($this->get('validator')));
        $this->set('auth', $this->services['auth'] ?? new Auth($this->get('sessions')));
    }

    /**
     * Creates and returns an instance of the HTTP kernel.
     *
     * @return Kernel The application kernel.
     *
     * @throws Exception
     */
    private function createKernel(): Kernel
    {
        return new Kernel(
            $this->get('request'),
            $this->get('response')
        );
    }

    /**
     * Loads the environment configuration from the `.env` file.
     */
    private function loadEnvironment(): void
    {
        try {
            Env::load(APP_ROOT.'/.env');
        } catch (Exception $e) {
            ErrorHandler::handleException($e);
        }
    }

    /**
     * Sets up error handling for the application.
     *
     * Configures error and exception handlers based on the `APP_DEBUG` environment variable.
     */
    private function setupErrorHandling(): void
    {
        $debug = Env::get('APP_DEBUG') === 'true';

        if ($debug) {
            ErrorHandler::register();
        } else {
            $this->setProductionErrorHandlers();
        }
    }

    /**
     * Configures error handlers for production mode.
     *
     * Ensures that errors are handled gracefully with minimal information disclosure.
     */
    private function setProductionErrorHandlers(): void
    {
        set_exception_handler(fn () => abort(500, 'Internal Server Error'));
        set_error_handler(function (int $errno): bool {
            if (! (error_reporting() & $errno)) {
                return false;
            }

            abort(500, 'Internal Server Error');
        });
        register_shutdown_function(function () {
            $error = error_get_last();
            if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true)) {
                abort(500, 'Internal Server Error');
            }
        });
    }

    /**
     * Initializes application configuration.
     *
     * This method loads the configuration file into the application.
     *
     * @throws Exception
     */
    private function initializeConfig(): void
    {
        $this->loadConfig();
    }

    /**
     * Loads and returns the application configuration.
     *
     * @return array The application configuration as an associative array.
     *
     * @throws Exception If the configuration file is missing or invalid.
     */
    private function loadConfig(): array
    {
        $configPath = str_replace(DIRECTORY_SEPARATOR, '/', APP_ROOT.'/config/config.php');

        if (! file_exists($configPath)) {
            throw new Exception('Config file not found.');
        }

        $config = require $configPath;

        if (! is_array($config)) {
            throw new Exception('Config file is not an array.');
        }

        return $config;
    }

    /**
     * Loads helper functions required by the application.
     *
     * Ensures the helpers file is available and includes it.
     */
    private function loadHelpers(): void
    {
        $helpersPath = APP_ROOT.'/core/App/helpers.php';

        if (! file_exists($helpersPath)) {
            ErrorHandler::handleException(new Exception('Helpers file not found.'));

            return;
        }

        require_once $helpersPath;
    }
}
