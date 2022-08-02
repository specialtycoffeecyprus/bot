<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Exceptions\NotFoundException;
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

        if (!$exception instanceof NotFoundException) {
            error_log((string)$exception);
        }

        return $this->sender->send($this->getAnswer());
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer("Whoops!\n".$this->exception->getMessage());
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
