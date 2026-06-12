<?php

declare(strict_types=1);

use Horizon\Arch\Application;
use Horizon\Http\Collection\MiddlewareCollection;

return Application::configure(basePath: dirname(__DIR__))
    ->withPaths(function (Application $app) {
        //
    })
    ->withProviders(
        providers: APP_ROOT . '/boot/providers.php'
    )
    ->withRouting(
        web: APP_ROOT . '/routes/web.php'
    )
    ->withMiddleware(function (MiddlewareCollection $middleware) {
        //
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->withEnvironment(function (Application $app) {
        $app->environmentFile(
            APP_ROOT . '/.env'
        )
            ->developmentEnvironmentFile(
                APP_ROOT . '/.env.development'
            )
            ->localEnvironmentFile(
                APP_ROOT . '/.env.local'
            )
            ->productionEnvironmentFile(
                APP_ROOT . '/.env.production'
            )
            ->testingEnvironmentFile(
                APP_ROOT . '/.env.testing'
            );
    })
    ->create();