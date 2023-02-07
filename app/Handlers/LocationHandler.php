<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Handlers\Handler as BaseHandler;
use App\Services\ApiService;
use App\Services\Formatter;
use App\Services\Sender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

final class LocationHandler extends BaseHandler
{
    private Location $location;


    public function __construct(Sender $sender, private readonly ApiService $api)
    {
        parent::__construct($sender);
    }


    public function __invoke(Nutgram $bot): ?Message
    {
        $this->location = $bot->message()->location;

        return $this->sender->send($this->getAnswer());
    }


    /** @inheritDoc */
    public function getAnswer(): Answer|array
    {
        $cafe = $this->api->getNearest((string) $this->location->latitude, (string) $this->location->longitude);

        return [
            new TextAnswer(Formatter::item($cafe), ['parse_mode' => ParseMode::HTML]),

            new VenueAnswer((float) $cafe->latitude, (float) $cafe->longitude, $cafe->name, $cafe->region, [
                'google_place_id' => $cafe->placeId,
                'reply_to_message_id' => 0,
                'reply_markup' => ['remove_keyboard' => true],
            ]),
        ];
    }


    public function getLocation(): Location
    {
        return $this->location;
    }


    public function setLocation(Location $location): LocationHandler
    {
        $this->location = $location;

        return $this;
    }
}
