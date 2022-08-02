<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

use App\Answers\Answer;
use App\Answers\TextAnswer;
use App\Handlers\Commands\Command as BaseCommand;

final class MapCommand extends BaseCommand
{
    public static function getName(): string
    {
        return 'map';
    }


    public static function getDescription(): string
    {
        return 'Map of specialty coffee shops';
    }


    public function getAnswer(): Answer
    {
        return new TextAnswer('See the map of all coffee shops on the site https://specialtycoffee.cy');
    }
}
