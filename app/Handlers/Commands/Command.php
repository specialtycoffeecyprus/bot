<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Contracts\Command as CommandContract;
use App\Handlers\Handler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

abstract class Command extends Handler implements CommandContract
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $this->sender->send($this->getAnswer());
    }
}
