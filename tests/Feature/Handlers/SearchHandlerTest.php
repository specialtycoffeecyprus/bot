<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Handlers\SearchHandler;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(SearchHandler::class);
});

test('handle search for exist input', function (string $text): void {
    /** @var <TextAnswer, VenueAnswer>[] $answers */
    $answers = $this->handler->setText($text)->getAnswer();

    $this->bot->hearText($text)->reply()
        ->assertReplyText($answers[0]->text)
        ->assertReply('sendVenue', json_decode(json_encode($answers[1], JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR), 1);
})->with('Search exist');
