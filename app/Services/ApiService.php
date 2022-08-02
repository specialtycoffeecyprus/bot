<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Cafe;
use App\Exceptions\NotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use stdClass;

use function array_map;
use function json_decode;

use const JSON_THROW_ON_ERROR;

final class ApiService
{

    public function __construct(private readonly Client $client)
    {
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getList(): array
    {
        $geoJsonData = $this->get('/');

        if ($geoJsonData->features === []) {
            throw new NotFoundException();
        }

        return array_map(static fn(stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getRandom(): Cafe
    {
        $feature = $this->get('/random');

        return Cafe::makeFromFeature($feature);
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getSearch(string $text): array
    {
        $geoJsonData = $this->get('/search', ['query' => ['q' => $text]]);

        if ($geoJsonData->features === []) {
            throw new NotFoundException();
        }

        return array_map(static fn(stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getNearest(string $latitude, string $longitude): Cafe
    {
        $feature = $this->get('/nearest', ['query' => ['latitude' => $latitude, 'longitude' => $longitude]]);

        return Cafe::makeFromFeature($feature);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    private function get(string $uri, array $options = []): stdClass
    {
        $uri = "/cafes$uri";
        $uri = rtrim($uri, '/');

        return json_decode($this->client->get($uri, $options)->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
    }
}
