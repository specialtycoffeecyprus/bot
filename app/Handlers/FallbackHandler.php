<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Handlers\Handler as BaseHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class FallbackHandler extends BaseHandler
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $this->sender->send($this->getAnswer());
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer("Sorry, I don't understand");
    }
}
