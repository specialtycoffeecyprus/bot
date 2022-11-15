<?php

declare(strict_types=1);

use Illuminate\Support\Str;

dataset('Search non-exist', static fn (): array => [
    Str::random(),
]);
