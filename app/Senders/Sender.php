<?php

declare(strict_types=1);

namespace App\Senders;

use SergiX44\Nutgram\Nutgram;

abstract class Sender
{
    public function __construct(protected readonly Nutgram $bot)
    {
    }
}
