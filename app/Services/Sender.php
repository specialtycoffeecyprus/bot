<?php

declare(strict_types=1);

namespace App\Services;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Senders\TextSender;
use App\Senders\VenueSender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use function array_reduce;
use function call_user_func;
use function is_array;

final class Sender
{
    private int $replyToMessageId = 0;


    public function __construct(private readonly Nutgram $bot)
    {
    }


    /** @param Answer|array<Answer> $answers */
    public function send(Answer|array $answers): ?Message
    {
        if (!is_array($answers)) {
            $answers = [$answers];
        }

        return array_reduce($answers, fn (?Message $carry, Answer $answer): ?Message => $this->sendOne($answer));
    }


    private function sendOne(Answer $answer): ?Message
    {
        if ($answer->hasReplyTo()) {
            $answer->setReplyTo($this->replyToMessageId);
        }

        $sender = match ($answer::class) {
            TextAnswer::class => TextSender::class,
            VenueAnswer::class => VenueSender::class,
        };

        /** @var ?Message $previousMessage */
        $previousMessage = call_user_func($this->bot->resolve($sender), $answer);

        $this->replyToMessageId = $previousMessage?->message_id;

        return $previousMessage;
    }
}
