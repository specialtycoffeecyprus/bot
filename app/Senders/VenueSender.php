<?php

declare(strict_types=1);

namespace App\Senders;

use App\Answers\VenueAnswer;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class VenueSender extends Sender
{
    public function __invoke(VenueAnswer $answer): ?Message
    {
        return $this->bot->sendVenue($answer->latitude, $answer->longitude, $answer->title, $answer->address, $answer->getOpts());
    }
}
