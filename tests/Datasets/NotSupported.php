<?php

declare(strict_types=1);

use App\Handlers\Commands\NearestCommand;

dataset('Not supported', static fn(): array => [
    NearestCommand::SEND_TEXT
]);
