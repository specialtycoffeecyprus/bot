<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

print_r($_SERVER);
error_log(print_r($_SERVER, true));
// Process requests from own canonical address
if (str_ends_with((string) $_ENV['APP_URL'], '://'.$_SERVER['HTTP_HOST'])) {
    // Process normal requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['SCRIPT_NAME'] === '/index.php' && $_SERVER['REQUEST_URI'] === '/') {
        return false;
    }

    // Process GET requests from health-check or requests to static files
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        return $_SERVER['SCRIPT_NAME'] === '/index.php';
    }

    // Reject other requests
    http_response_code(405);

    return true;
}

// Internal Consul Health Check
if ($_SERVER['HTTP_USER_AGENT'] === 'Consul Health Check' && $_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['SCRIPT_NAME'] === '/index.php' && $_SERVER['REQUEST_URI'] === '/') {
    return true;
}

// Reject other requests
http_response_code(404);
