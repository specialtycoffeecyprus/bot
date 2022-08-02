<?php

declare(strict_types=1);

namespace App\Answers;

final class VenueAnswer extends Answer
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly string $title,
        public readonly string $address,
        protected array $opts = []
    ) {
        parent::__construct($this->opts);
    }
}
