<?php

declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use App\Commands\ListCommand;
use App\Commands\MapCommand;
use App\Commands\NearestCommand;
use App\Commands\RandomCommand;
use App\Commands\StartCommand;
use App\Handlers\ApiErrorHandler;
use App\Handlers\ExceptionHandler;
use App\Handlers\FallbackHandler;
use App\Handlers\LocationHandler;
use App\Handlers\SearchHandler;
use App\Handlers\StubHandler;
use App\Middleware\AuthMiddleware;
use App\Middleware\SearchRequirementsMiddleware;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use Symfony\Component\Dotenv\Dotenv;

use function Sentry\init;

$dotenv = new Dotenv();
$dotenv->loadEnv(dirname(__DIR__).'/.env');

init(['dsn' => $_ENV['SENTRY_DSN']]);

$bot = new Nutgram($_ENV['BOT_TOKEN']);
$bot->setRunningMode(Webhook::class);

$bot->middleware(AuthMiddleware::class);

$bot->fallback(FallbackHandler::class);
$bot->onException(ExceptionHandler::class);
$bot->onApiError(ApiErrorHandler::class);

$bot->onText(NearestCommand::SEND_TEXT, StubHandler::class);

$bot->onMessageType(MessageTypes::TEXT, SearchHandler::class)->middleware(SearchRequirementsMiddleware::class);
$bot->onMessageType(MessageTypes::LOCATION, LocationHandler::class);

$bot->onCommand(ListCommand::getName(), ListCommand::class)->description(ListCommand::getDescription());
$bot->onCommand(MapCommand::getName(), MapCommand::class)->description(MapCommand::getDescription());
$bot->onCommand(NearestCommand::getName(), NearestCommand::class)->description(NearestCommand::getDescription());
$bot->onCommand(RandomCommand::getName(), RandomCommand::class)->description(RandomCommand::getDescription());
$bot->onCommand(StartCommand::getName(), StartCommand::class)->description(StartCommand::getDescription());

$bot->registerMyCommands();

$bot->run();
