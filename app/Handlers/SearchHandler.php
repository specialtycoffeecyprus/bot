<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Services\ApiService;
use App\Services\Sender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class SearchHandler
{
    public function __construct(private readonly ApiService $api, private readonly Sender $sender)
    {
    }


    public function __invoke(Nutgram $bot): ?Message
    {
        return $this->sender->sendItems($this->api->getSearch($bot->message()->text));
    }
}
