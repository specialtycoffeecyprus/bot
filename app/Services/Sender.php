<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Cafe;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function array_reduce;

final class Sender
{
    public function __construct(private readonly Nutgram $bot)
    {
    }


    public function sendItem(Cafe $cafe, array $opt = []): ?Message
    {
        $message = $this->bot->sendMessage(Formatter::item($cafe), ['parse_mode' => ParseMode::HTML]);

        return $this->bot->sendVenue(
            (float)$cafe->latitude, (float)$cafe->longitude, $cafe->name, '', [
                ...[
                    'google_place_id' => $cafe->placeId,
                    'reply_to_message_id' => $message?->message_id,
                ],
                ...$opt,
            ]
        );
    }


    /** @param Cafe[] $cafes */
    public function sendItems(array $cafes, array $opt = []): ?Message
    {
        return array_reduce($cafes, function (?Message $carry, Cafe $cafe) use ($opt): ?Message {
            return $this->sendItem($cafe, $opt);
        });
    }
}
