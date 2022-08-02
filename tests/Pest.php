<?php

declare(strict_types=1);

use SergiX44\Nutgram\Nutgram;
use Symfony\Component\Dotenv\Dotenv;
use Tests\TestCase;

uses(TestCase::class)->beforeAll(static function (): void {
    $dotenv = new Dotenv();
    $dotenv->loadEnv(dirname(__DIR__).'/.env');
})->beforeEach(function (): void {
    $this->bot = Nutgram::fake();
    $this->bootInstance($this->bot);
    $this->mockApi($this->bot);
})->in(__DIR__);
