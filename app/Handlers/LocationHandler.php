<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Services\ApiService;
use App\Services\Sender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

class LocationHandler
{
    public function __construct(private readonly ApiService $api, private readonly Sender $sender)
    {
    }


    public function __invoke(Nutgram $bot): ?Message
    {
        $location = $bot->message()->location;

        return $this->sender->sendItem(
            $this->api->getNearest((string)$location->latitude, (string)$location->longitude), [
                'reply_markup' => ['remove_keyboard' => true],
            ]
        );
    }
}
