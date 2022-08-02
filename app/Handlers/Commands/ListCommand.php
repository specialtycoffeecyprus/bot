<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Dto\Cafe;
use App\Handlers\Commands\Command as BaseCommand;
use App\Services\ApiService;
use App\Services\Formatter;
use App\Services\Sender;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;

use function array_walk;

final class ListCommand extends BaseCommand
{
    public function __construct(Sender $sender, private readonly ApiService $api)
    {
        parent::__construct($sender);
    }


    public static function getName(): string
    {
        return 'list';
    }


    public static function getDescription(): string
    {
        return 'List all specialty coffee shops';
    }


    /** @inheritDoc */
    public function getAnswer(): Answer|array
    {
        $cafes = $this->api->getList();

        $answers = [];

        array_walk($cafes, static function (Cafe $cafe) use (&$answers): void {
            $answers[] = new TextAnswer(Formatter::item($cafe), ['parse_mode' => ParseMode::HTML]);

            $answers[] = new VenueAnswer((float)$cafe->latitude, (float)$cafe->longitude, $cafe->name, '', [
                'google_place_id' => $cafe->placeId,
                'reply_to_message_id' => 0,
            ]);
        });

        return $answers;
    }
}
