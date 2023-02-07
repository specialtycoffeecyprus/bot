<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Handlers\Commands\Command as BaseCommand;
use App\Services\ApiService;
use App\Services\Formatter;
use App\Services\Sender;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

final class RandomCommand extends BaseCommand
{
    public function __construct(Sender $sender, private readonly ApiService $api)
    {
        parent::__construct($sender);
    }


    public static function getName(): string
    {
        return 'random';
    }


    public static function getDescription(): string
    {
        return 'Show random specialty coffee shop';
    }


    /** @inheritDoc */
    public function getAnswer(): Answer|array
    {
        $cafe = $this->api->getRandom();

        return [
            new TextAnswer(Formatter::item($cafe), ['parse_mode' => ParseMode::HTML]),

            new VenueAnswer((float) $cafe->latitude, (float) $cafe->longitude, $cafe->name, $cafe->region, [
                'google_place_id' => $cafe->placeId,
                'reply_to_message_id' => 0,
            ]),
        ];
    }
}
