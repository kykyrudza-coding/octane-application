<?php

use App\Http\Controllers\HomeController;
use App\Http\Middlewares\AdminMiddleware;
use App\Http\Middlewares\UserMiddleware;
use Kernel\Application\Routing\Route;

return [

    Route::get('/', [HomeController::class, 'index'])
        ->middleware([
            UserMiddleware::class,
            AdminMiddleware::class,
        ])
        ->name('home'),

    Route::get('/test/{name}', [HomeController::class, 'test'])->name('test'),

    Route::get('/get', [HomeController::class, 'get']),

    Route::get('/test-validation', [HomeController::class, 'testValidation'])->name('test-validation'),
    Route::post('/test-validation', [HomeController::class, 'storeValidation'])->name('test.store'),
];
