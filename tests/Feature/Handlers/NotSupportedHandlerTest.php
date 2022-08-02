<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Handlers\NotSupportedHandler;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(NotSupportedHandler::class);
});

test('handle not supported features', function (string $text): void {
    /** @var TextAnswer $answer */
    $answer = $this->handler->getAnswer();

    $this->bot->hearText($text)->reply()->assertReplyText($answer->text);
})->with('Not supported');
