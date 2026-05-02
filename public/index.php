<?php

/**
 * Entry point for the web application.
 *
 * This script is the entry point for starting the web application. It defines
 * the root directory of the application (`APP_ROOT`), loads the Composer
 * autoloader, enables error reporting for development purposes, and finally
 * creates an instance of the `Application` class to run the application.
 *
 * The script is executed when the web server handles an incoming request and
 * directs it to this file.
 */

// Use the Application class for handling the request and running the app.
use Kernel\Application\Application;

// Define the root directory of the application.
define('APP_ROOT', dirname(__DIR__));

// Include the Composer autoloader to load dependencies and application classes.
require_once APP_ROOT.'/vendor/autoload.php';

// Enable error display and set the error reporting level to show all errors.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Create and run the application instance to handle the incoming request.
$app = new Application;
$app->run();
