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

class ApiService
{
    private readonly Client $client;


    public function __construct()
    {
        $this->client = new Client(['base_uri' => $_ENV['API_URL']]);
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getList(): array
    {
        $geoJsonData = json_decode($this->client->get('/cafes')->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        if ($geoJsonData->features === []) {
            throw new NotFoundException();
        }

        return array_map(static fn(stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    /**
     * @return Cafe
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getRandom(): Cafe
    {
        $feature = json_decode($this->client->get('/cafes/random')->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        return Cafe::makeFromFeature($feature);
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getSearch(string $text): array
    {
        $geoJsonData = json_decode($this->client->get('/cafes/search', ['query' => ['q' => $text]])->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        if ($geoJsonData->features === []) {
            throw new NotFoundException();
        }

        return array_map(static fn(stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    public function getNearest(string $latitude, string $longitude): Cafe
    {
        $feature = json_decode($this->client->get('/cafes/nearest', ['query' => ['latitude' => $latitude, 'longitude' => $longitude]])->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        return Cafe::makeFromFeature($feature);
    }
}
