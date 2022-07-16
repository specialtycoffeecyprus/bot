<?php

declare(strict_types=1);

namespace App\Handlers;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class StubHandler
{
    public function __invoke(Nutgram $bot): ?Message
    {
        return $bot->sendMessage('<i>This message is currently not supported on Telegram Web. Try <a href="https://getdesktop.telegram.org/" target="_blank">getdesktop.telegram.org</a></i>', [
            'parse_mode' => ParseMode::HTML,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => $bot->messageId(),
            'reply_markup' => ['remove_keyboard' => true],
        ]);
    }
}
