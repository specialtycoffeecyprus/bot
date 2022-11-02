<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Handlers\Commands\Command as BaseCommand;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

final class NearestCommand extends BaseCommand
{
    public const SEND_TEXT = 'Send location';


    public static function getName(): string
    {
        return 'nearest';
    }


    public static function getDescription(): string
    {
        return 'Show nearest specialty coffee shop';
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer('Send your location to find the nearest coffee shop', [
            'reply_markup' => ReplyKeyboardMarkup::make(
                resize_keyboard: true,
                one_time_keyboard: true,
                selective: true
            )->addRow(KeyboardButton::make(
                self::SEND_TEXT,
                request_location: true
            )),
            'reply_to_message_id' => 0,
        ]);
    }
}
