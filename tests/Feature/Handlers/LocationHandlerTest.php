<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Handlers\LocationHandler;
use SergiX44\Nutgram\Telegram\Types\Location\Location;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(LocationHandler::class);
});

test('handle search by location', function (float $latitude, float $longitude): void {
    $location = new Location();
    $location->latitude = $latitude;
    $location->longitude = $longitude;

    /** @var <TextAnswer, VenueAnswer>[] $answers */
    $answers = $this->handler->setLocation($location)->getAnswer();

    $this->bot->hearMessage(['location' => ['latitude' => $location->latitude, 'longitude' => $location->longitude]])->reply()
        ->assertReplyText($answers[0]->text)
        ->assertReply('sendVenue', json_decode(json_encode($answers[1], JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR), 1);
})->with('Search location');
