<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Handlers\Commands\RandomCommand;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(RandomCommand::class);
});

test('handle /random command', function (): void {
    /** @var <TextAnswer, VenueAnswer>[] $answers */
    $answers = $this->handler->getAnswer();

    $this->bot->hearText('/'.$this->handler::getName())->reply()
        ->assertReplyText($answers[0]->text)
        ->assertReply('sendVenue', json_decode(json_encode($answers[1], JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR), 1);
});
