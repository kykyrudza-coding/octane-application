<?php

declare(strict_types=1);

use Horizon\Arch\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withEnvironment(function (Application $app) {
        $app->environmentFile(
            APP_ROOT.'/'.env('APP_ENV_FILE', '.env')
        )
            ->developmentEnvironmentFile(
                APP_ROOT.'/'.env('APP_ENV_DEVELOPMENT_FILE', '.env.development')
            )
            ->localEnvironmentFile(
                APP_ROOT.'/'.env('APP_ENV_LOCAL_FILE', '.env.local')
            )
            ->productionEnvironmentFile(
                APP_ROOT.'/'.env('APP_ENV_PRODUCTION_FILE', '.env.production')
            )
            ->testingEnvironmentFile(
                APP_ROOT.'/'.env('APP_ENV_TESTING_FILE', '.env.testing')
            );
    })
    ->create();
