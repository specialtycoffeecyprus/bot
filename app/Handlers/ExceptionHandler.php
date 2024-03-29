<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Exceptions\LocationPublicDenied;
use App\Exceptions\NotFound;
use App\Handlers\Handler as BaseHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use Throwable;

use function error_log;

final class ExceptionHandler extends BaseHandler
{
    private Throwable $exception;


    public function __invoke(Nutgram $bot, Throwable $exception): ?Message
    {
        $this->exception = $exception;

        if (!$exception instanceof NotFound && !$exception instanceof LocationPublicDenied) {
            error_log((string) $exception);
        }

        return $this->sender->send($this->getAnswer());
    }


    public function getAnswer(): Answer
    {
        if ($this->exception instanceof NotFound || $this->exception instanceof LocationPublicDenied) {
            return new TextAnswer($this->exception->getMessage());
        }

        return new TextAnswer("Whoops!\nSomething went wrong!");
    }


    public function getException(): Throwable
    {
        return $this->exception;
    }


    public function setException(Throwable $exception): ExceptionHandler
    {
        $this->exception = $exception;

        return $this;
    }
}
