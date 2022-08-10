<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\NullAnswer;
use App\Handlers\Handler as BaseHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class NullHandler extends BaseHandler
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return null;
    }


    public function getAnswer(): Answer
    {
        return new NullAnswer();
    }
}
