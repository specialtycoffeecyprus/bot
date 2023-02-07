<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Cafe;

final class Formatter
{
    public static function item(Cafe $cafe): string
    {
        return "<b>$cafe->name</b>

<i>$cafe->region</i>

{$cafe->description}

<a href=\"$cafe->url\">View on Google Maps</a>";
    }
}
