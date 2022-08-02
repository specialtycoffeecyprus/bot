<?php

declare(strict_types=1);

namespace Tests\Feature\Handlers;

use App\Contracts\Handler;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected Handler $handler;
}
