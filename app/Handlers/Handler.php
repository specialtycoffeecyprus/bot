<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Contracts\Handler as HandlerContract;
use App\Services\Sender;

abstract class Handler implements HandlerContract
{
    public function __construct(protected readonly Sender $sender)
    {
    }
}
