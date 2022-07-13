<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command;
use App\Services\ApiService;
use App\Services\Sender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class ListCommand implements Command
{
    public function __construct(private readonly ApiService $api, private readonly Sender $sender)
    {
    }


    public function __invoke(Nutgram $bot): ?Message
    {
        return $this->sender->sendItems($this->api->getList());
    }


    public static function getName(): string
    {
        return 'list';
    }


    public static function getDescription(): string
    {
        return 'List all specialty coffee shops';
    }
}
