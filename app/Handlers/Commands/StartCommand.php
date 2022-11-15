<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Handlers\Commands\Command as BaseCommand;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

class StartCommand extends BaseCommand
{
    public static function getName(): string
    {
        return 'start';
    }


    public static function getDescription(): string
    {
        return 'How to use this bot';
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer(
            'Write coffee shop <b><i>name</i></b> or part to search by
Send your <b><i>location</i></b> to search nearest coffee shop

Or use the following commands for more
/'.ListCommand::getName().' - '.ListCommand::getDescription().'
/'.MapCommand::getName().' - '.MapCommand::getDescription().'
/'.NearestCommand::getName().' - '.NearestCommand::getDescription().'
/'.RandomCommand::getName().' - '.RandomCommand::getDescription().'

More about the project on the site https://specialtycoffee.cy/about/',
            [
                'parse_mode' => ParseMode::HTML,
                'disable_web_page_preview' => true,
            ]
        );
    }
}
