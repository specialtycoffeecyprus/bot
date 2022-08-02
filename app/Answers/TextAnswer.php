<?php

declare(strict_types=1);

namespace App\Answers;

final class TextAnswer extends Answer
{
    public function __construct(public readonly string $text, protected array $opts = [])
    {
        parent::__construct($this->opts);
    }
}
