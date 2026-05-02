<?php

namespace App\Http\Middlewares;

use Kernel\Application\Http\Request;
use Kernel\Application\Http\Response;

class AdminMiddleware
{
    public function handle(Request $request, Response $response): string
    {
        return '123';
    }
}
