<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Handlers\Handler as BaseHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class NotSupportedHandler extends BaseHandler
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $this->sender->send($this->getAnswer());
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer('<i>This message is currently not supported on Telegram Web. Try <a href="https://getdesktop.telegram.org/" target="_blank">getdesktop.telegram.org</a></i>', [
            'parse_mode' => ParseMode::HTML,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => 0,
            'reply_markup' => ['remove_keyboard' => true],
        ]);
    }
}
