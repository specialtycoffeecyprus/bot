<?php

declare(strict_types=1);

namespace App\Senders;

use App\Answers\TextAnswer;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class TextSender extends Sender
{
    public function __invoke(TextAnswer $answer): ?Message
    {
        return $this->bot->sendMessage($answer->text, $answer->getOpts());
    }
}
