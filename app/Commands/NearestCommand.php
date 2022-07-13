<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class NearestCommand implements Command
{
    public const SEND_TEXT = 'Send location';


    public function __invoke(Nutgram $bot): ?Message
    {
        return $bot->sendMessage('Send your location to find nearest coffee shop', [
            'reply_markup' => ReplyKeyboardMarkup::make(resize_keyboard: true)->addRow(KeyboardButton::make(self::SEND_TEXT, request_location: true)),
        ]);
    }


    public static function getName(): string
    {
        return 'nearest';
    }


    public static function getDescription(): string
    {
        return 'Show nearest specialty coffee shop';
    }
}
