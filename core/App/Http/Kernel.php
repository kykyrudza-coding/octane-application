<?php

namespace Kernel\Application\Http;

use Exception;
use Kernel\Application\Errors\ErrorHandler;
use Kernel\Application\Routing\Router;

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
            ob_end_flush();
        } catch (Exception $e) {
            ob_end_clean();
            new ErrorHandler('Internal Server Error', 500, $e->getFile(), $e->getLine());
        }
    }

    private function getRoutes(): array
    {
        return require_once APP_ROOT.'/routes/web.php';
    }
}
