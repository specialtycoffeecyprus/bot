<?php

declare(strict_types=1);

namespace App\Dto;

use stdClass;

final class Cafe
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $placeId,
        public readonly string $latitude,
        public readonly string $longitude
    ) {
    }


    public static function makeFromFeature(stdClass $feature): self
    {
        return new self(
            $feature->id, $feature->properties->name, $feature->properties->description, $feature->properties->placeId, (string)$feature->geometry->coordinates[1], (string)$feature->geometry->coordinates[0]
        );
    }
}
