<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\AuthRequiredException;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function array_key_exists;

final class AuthMiddleware
{
    public function __invoke(Nutgram $bot, Link $next): ?Message
    {
        if (!array_key_exists('HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN', $_SERVER) || $_SERVER['HTTP_X_TELEGRAM_BOT_API_SECRET_TOKEN'] !== $_ENV['BOT_SECRET']) {
            throw new AuthRequiredException();
        }

        return $next($bot);
    }
}
