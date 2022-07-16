<?php

declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use SergiX44\Nutgram\Nutgram;
use Symfony\Component\Dotenv\Dotenv;

use function Sentry\init;

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

init(['dsn' => $_ENV['SENTRY_DSN']]);

$bot = new Nutgram($_ENV['BOT_TOKEN']);
$bot->setWebhook($_ENV['APP_URL'], ['secret_token' => $_ENV['BOT_SECRET']]);
