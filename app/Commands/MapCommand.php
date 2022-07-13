<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class MapCommand implements Command
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $bot->sendMessage('See the map of all coffee shops on the site https://specialtycoffee.cy');
    }


    public static function getName(): string
    {
        return 'map';
    }


    public static function getDescription(): string
    {
        return 'Map of specialty coffee shops';
    }
}
