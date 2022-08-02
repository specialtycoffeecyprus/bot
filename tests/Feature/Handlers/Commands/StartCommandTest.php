<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Handlers\Commands\StartCommand;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(StartCommand::class);
});

test('handle /start command', function (): void {
    /** @var TextAnswer $answer */
    $answer = $this->handler->getAnswer();

    $this->bot->hearText('/'.$this->handler::getName())->reply()->assertReplyText($answer->text);
});
