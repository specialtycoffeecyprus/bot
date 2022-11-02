<?php

declare(strict_types=1);

namespace App\Handlers\Commands;

final class HelpCommand extends StartCommand
{
    public static function getName(): string
    {
        return 'help';
    }
}
