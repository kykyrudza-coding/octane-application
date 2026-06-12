<?php

//use Horizon\Routing\Route;
//
//Route::get('/', function () {
//    return view('welcome');
//});

use Horizon\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/test', fn () => 'test');