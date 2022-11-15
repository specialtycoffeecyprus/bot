<?php

declare(strict_types=1);

use App\Answers\TextAnswer;
use App\Exceptions\NotFound;
use App\Handlers\ExceptionHandler;

beforeEach(function (): void {
    $this->handler = $this->bot->resolve(ExceptionHandler::class);
});

test('handle exception for non-exist search result', function (string $text): void {
    /** @var TextAnswer $answer */
    $answer = $this->handler->setException(new NotFound())->getAnswer();

    $this->bot->hearText($text)->reply()->assertReplyText($answer->text);
})->with('Search non-exist');
