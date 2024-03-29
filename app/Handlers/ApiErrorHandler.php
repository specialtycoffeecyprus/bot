<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Exceptions\LocationPublicDenied;
use App\Handlers\Handler as BaseHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function error_log;

final class ApiErrorHandler extends BaseHandler
{
    private TelegramException $exception;


    public function __invoke(Nutgram $bot, TelegramException $exception): ?Message
    {
        $this->exception = $exception;

        if ($this->exception->getMessage() === LocationPublicDenied::TEXT) {
            throw new LocationPublicDenied();
        }

        error_log((string) $exception);

        return $this->sender->send($this->getAnswer());
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer("Whoops, Telegram!\nSomething went wrong!");
    }


    public function getException(): TelegramException
    {
        return $this->exception;
    }


    public function setException(TelegramException $exception): ApiErrorHandler
    {
        $this->exception = $exception;

        return $this;
    }
}
