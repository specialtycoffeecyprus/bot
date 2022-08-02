<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Handlers\FallbackHandler;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(FallbackHandler::class);
});

test('handle fallback for input', function (string $text): void {
    /** @var TextAnswer $answer */
    $answer = $this->handler->getAnswer();

    $this->bot->hearText($text)->reply()->assertReplyText($answer->text);
})->with('Fallback');
