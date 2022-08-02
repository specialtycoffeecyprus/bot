<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Handlers\FallbackHandler;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function call_user_func;

final class SearchRequirementsMiddleware
{
    public function __invoke(Nutgram $bot, Link $next): ?Message
    {
        $strlen = mb_strlen($bot->message()->text);

        if ($strlen >= 3 && $strlen <= 255) {
            return $next($bot);
        }

        return call_user_func($bot->resolve(FallbackHandler::class), $bot);
    }
}
