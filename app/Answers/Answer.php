<?php

declare(strict_types=1);

namespace App\Answers;

use App\Contracts\Answer as AnswerContract;

use function array_key_exists;

abstract class Answer implements AnswerContract
{
    /** @param array<string> $opts */
    public function __construct(protected array $opts = [])
    {
    }


    /** @return array<string> $opts */
    public function getOpts(): array
    {
        return $this->opts;
    }


    public function hasReplyTo(): bool
    {
        return array_key_exists('reply_to_message_id', $this->opts);
    }


    public function setReplyTo(int $replyToMessageId): self
    {
        $this->opts['reply_to_message_id'] = $replyToMessageId;

        return $this;
    }
}
