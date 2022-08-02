<?php

declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use App\Handlers\ApiErrorHandler;
use App\Handlers\Commands\ListCommand;
use App\Handlers\Commands\MapCommand;
use App\Handlers\Commands\NearestCommand;
use App\Handlers\Commands\RandomCommand;
use App\Handlers\Commands\StartCommand;
use App\Handlers\ExceptionHandler;
use App\Handlers\FallbackHandler;
use App\Handlers\LocationHandler;
use App\Handlers\SearchHandler;
use App\Handlers\NotSupportedHandler;
use App\Middleware\AuthMiddleware;
use App\Middleware\SearchRequirementsMiddleware;
use GuzzleHttp\Client;
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

$bot->onText(NearestCommand::SEND_TEXT, NotSupportedHandler::class);

$bot->onMessageType(MessageTypes::TEXT, SearchHandler::class)->middleware(SearchRequirementsMiddleware::class);
$bot->onMessageType(MessageTypes::LOCATION, LocationHandler::class);

$bot->onCommand(ListCommand::getName(), ListCommand::class)->description(ListCommand::getDescription());
$bot->onCommand(MapCommand::getName(), MapCommand::class)->description(MapCommand::getDescription());
$bot->onCommand(NearestCommand::getName(), NearestCommand::class)->description(NearestCommand::getDescription());
$bot->onCommand(RandomCommand::getName(), RandomCommand::class)->description(RandomCommand::getDescription());
$bot->onCommand(StartCommand::getName(), StartCommand::class)->description(StartCommand::getDescription());

$bot->registerMyCommands();

$http = new Client(['base_uri' => $_ENV['API_URL']]);
$bot->getContainer()->addShared(Client::class, $http);

$bot->run();
