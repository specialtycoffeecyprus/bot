<?php

declare(strict_types=1);

namespace App\Dto;

use stdClass;

final readonly class Cafe
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $placeId,
        public string $latitude,
        public string $longitude
    ) {
    }


    public static function makeFromFeature(stdClass $feature): self
    {
        return new self(
            $feature->id,
            $feature->properties->name,
            $feature->properties->description,
            $feature->properties->placeId,
            (string) $feature->geometry->coordinates[1],
            (string) $feature->geometry->coordinates[0]
        );
    }
}
