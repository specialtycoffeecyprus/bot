<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class StartCommand implements Command
{
    public function __invoke(Nutgram $bot): ?Message
    {
        $text = 'Write coffee shop <b><i>name</i></b> or part to search by
Send your <b><i>location</i></b> to search nearest coffee shop

Or use the following commands for more
/'.ListCommand::getName().' - '.ListCommand::getDescription().'
/'.MapCommand::getName().' - '.MapCommand::getDescription().'
/'.NearestCommand::getName().' - '.NearestCommand::getDescription().'
/'.RandomCommand::getName().' - '.RandomCommand::getDescription().'

More about the project on the site https://specialtycoffee.cy/about/';

        return $bot->sendMessage($text, ['parse_mode' => ParseMode::HTML, 'disable_web_page_preview' => true]);
    }


    public static function getName(): string
    {
        return 'start';
    }


    public static function getDescription(): string
    {
        return 'How to use this bot';
    }
}
