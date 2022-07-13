<?php

declare(strict_types=1);

namespace App\Handlers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class FallbackHandler
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $bot->sendMessage("Sorry, I don't understand");
    }
}
