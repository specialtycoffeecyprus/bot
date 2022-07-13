<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Exceptions\NotFoundException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use Throwable;

use function error_log;

class ExceptionHandler
{
    public function __invoke(Nutgram $bot, Throwable $exception): ?Message
    {
        if (!$exception instanceof NotFoundException) {
            error_log((string)$exception);
        }

        return $bot->sendMessage("Whoops!\n".$exception->getMessage());
    }
}
