<?php

namespace Kernel\Application\Http;

use Kernel\Application\Errors\ErrorHandler;
use Kernel\Application\Routing\Router;
use Throwable;

readonly class Kernel
{
    public function __construct(
        private Request $request,
        private Response $response,
    ) {}

    public function run(): void
    {
        ob_start();
        try {
            $routes = $this->getRoutes();
            $requestInfo = $this->request->getRequestInfo();

            $router = new Router;
            $router->dispatch($routes, $requestInfo, $this->request, $this->response);

            $this->response->send();
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
        } catch (Throwable $e) {
            if (ob_get_level() > 0) {
                ob_end_clean();
            }

            ErrorHandler::handleException($e);
        }
    }

    private function getRoutes(): array
    {
        return require_once APP_ROOT.'/routes/web.php';
    }
}
