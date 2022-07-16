<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

// Process requests from own canonical address
if (str_ends_with((string)$_ENV['APP_URL'], '://'.$_SERVER['HTTP_HOST'])) {
    // Process normal requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['SCRIPT_NAME'] === '/index.php') {
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

// Redirect requests from fly dev server to canonical address
if ($_SERVER['HTTP_HOST'] === $_ENV['FLY_APP'].'.'.$_ENV['FLY_DOMAIN']) {
    header('Location: '.$_ENV['APP_URL'].$_SERVER['REQUEST_URI'], true, 301);

    return true;
}

// Reject other requests
http_response_code(404);
