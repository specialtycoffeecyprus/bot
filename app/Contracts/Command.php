<?php

declare(strict_types=1);

namespace App\Contracts;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

interface Command
{
    public function __invoke(Nutgram $bot): ?Message;


    public static function getName(): string;


    public static function getDescription(): string;
}
