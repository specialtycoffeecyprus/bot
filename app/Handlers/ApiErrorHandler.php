<?php

declare(strict_types=1);

namespace App\Handlers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function error_log;

final class ApiErrorHandler
{
    public function __invoke(Nutgram $bot, TelegramException $exception): ?Message
    {
        error_log((string)$exception);
        return $bot->sendMessage("Whoops, Telegram!\n".$exception->getMessage());
    }
}
