<?php

use Horizon\Http\Request\RequestContext;

define('APP_ROOT', dirname(__DIR__));
define('OCTANE_START', microtime(true));

require_once APP_ROOT . '/vendor/autoload.php';

/** @var Horizon\Arch\Application $app */
$app = require_once APP_ROOT . '/boot/app.php';

$app->handleRequest(
    RequestContext::capture()
)->run();