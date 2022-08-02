<?php

declare(strict_types=1);

namespace Tests;

use App\Handlers\ApiErrorHandler;
use App\Handlers\Commands\ListCommand;
use App\Handlers\Commands\MapCommand;
use App\Handlers\Commands\NearestCommand;
use App\Handlers\Commands\RandomCommand;
use App\Handlers\Commands\StartCommand;
use App\Handlers\ExceptionHandler;
use App\Handlers\FallbackHandler;
use App\Handlers\LocationHandler;
use App\Handlers\NotSupportedHandler;
use App\Handlers\SearchHandler;
use App\Middleware\SearchRequirementsMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PHPUnit\Framework\TestCase as BaseTestCase;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Testing\FakeNutgram;

abstract class TestCase extends BaseTestCase
{
    protected FakeNutgram $bot;


    protected function bootInstance(FakeNutgram $bot): void
    {
        $bot->fallback(FallbackHandler::class);
        $bot->onException(ExceptionHandler::class);
        $bot->onApiError(ApiErrorHandler::class);

        $bot->onText(NearestCommand::SEND_TEXT, NotSupportedHandler::class);

        $bot->onMessageType(MessageTypes::TEXT, SearchHandler::class)->middleware(SearchRequirementsMiddleware::class);
        $bot->onMessageType(MessageTypes::LOCATION, LocationHandler::class);

        $bot->onCommand(ListCommand::getName(), ListCommand::class);
        $bot->onCommand(MapCommand::getName(), MapCommand::class);
        $bot->onCommand(NearestCommand::getName(), NearestCommand::class);
        $bot->onCommand(RandomCommand::getName(), RandomCommand::class);
        $bot->onCommand(StartCommand::getName(), StartCommand::class);
    }


    protected function mockApi(FakeNutgram $bot): void
    {
        $bot->getContainer()->addShared(Client::class, new Client(['handler' => HandlerStack::create(new ApiClient())]));
    }
}
