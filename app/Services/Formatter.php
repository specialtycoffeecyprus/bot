<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Cafe;

final class Formatter
{
    public static function item(Cafe $cafe): string
    {
        return "<b>{$cafe->name}</b>
{$cafe->description}
<a href=\"https://www.google.com/maps/place/?q=place_id:{$cafe->placeId}\">View on Google Maps</a>";
    }
}
