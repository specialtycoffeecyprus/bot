<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Handlers\Commands\MapCommand;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(MapCommand::class);
});

test('handle /map command', function (): void {
    /** @var TextAnswer $answer */
    $answer = $this->handler->getAnswer();

    $this->bot->hearText('/'.$this->handler::getName())->reply()->assertReplyText($answer->text);
});
