<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Answers\VenueAnswer;
use App\Dto\Cafe;
use App\Handlers\Handler as BaseHandler;
use App\Services\ApiService;
use App\Services\Formatter;
use App\Services\Sender;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\Message;

use function array_walk;

final class SearchHandler extends BaseHandler
{
    private string $text;


    public function __construct(Sender $sender, private readonly ApiService $api)
    {
        parent::__construct($sender);
    }


    public function __invoke(Nutgram $bot): ?Message
    {
        $this->text = $bot->message()->text;

        return $this->sender->send($this->getAnswer());
    }


    /** @inheritDoc */
    public function getAnswer(): Answer|array
    {
        $cafes = $this->api->getSearch($this->text);

        $answers = [];

        array_walk($cafes, static function (Cafe $cafe) use (&$answers): void {
            $answers[] = new TextAnswer(Formatter::item($cafe), ['parse_mode' => ParseMode::HTML]);

            $answers[] = new VenueAnswer((float) $cafe->latitude, (float) $cafe->longitude, $cafe->name, '', [
                'google_place_id' => $cafe->placeId,
                'reply_to_message_id' => 0,
            ]);
        });

        return $answers;
    }


    public function getText(): string
    {
        return $this->text;
    }


    public function setText(string $text): SearchHandler
    {
        $this->text = $text;

        return $this;
    }
}
