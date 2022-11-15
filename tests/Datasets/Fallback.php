<?php

declare(strict_types=1);

use Illuminate\Support\Str;

dataset('Fallback', static fn (): array => [
    'too short' => Str::random(2),
    'too long' => Str::random(256),
]);
