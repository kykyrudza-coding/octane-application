<?php

use Horizon\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});