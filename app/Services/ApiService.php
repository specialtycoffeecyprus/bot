<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Cafe;
use App\Exceptions\NotFound;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use stdClass;
use function array_map;
use function is_object;
use function json_decode;
use const JSON_THROW_ON_ERROR;

final readonly class ApiService
{
    public function __construct(private Client $client)
    {
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFound
     */
    public function getList(): array
    {
        $geoJsonData = $this->get('/');

        return array_map(static fn (stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFound
     */
    public function getRandom(): Cafe
    {
        $feature = $this->get('/random');

        if (!is_object($feature)) {
            throw new NotFound();
        }

        return Cafe::makeFromFeature($feature);
    }


    /**
     * @return Cafe[]
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFound
     */
    public function getSearch(string $text): array
    {
        $geoJsonData = $this->get('/search', ['query' => ['q' => $text]]);

        return array_map(static fn (stdClass $feature): Cafe => Cafe::makeFromFeature($feature), $geoJsonData->features);
    }


    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFound
     */
    public function getNearest(string $latitude, string $longitude): Cafe
    {
        $feature = $this->get('/nearest', ['query' => ['latitude' => $latitude, 'longitude' => $longitude]]);

        if (!is_object($feature)) {
            throw new NotFound();
        }

        return Cafe::makeFromFeature($feature);
    }


    /**
     * @return stdClass|stdClass[]
     * @throws JsonException
     * @throws GuzzleException
     * @throws NotFound
     */
    private function get(string $uri, array $options = []): stdClass|array
    {
        $uri = "/cafes$uri";
        $uri = rtrim($uri, '/');

        $data = json_decode($this->client->get($uri, $options)->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);

        if (!is_object($data) || (isset($data->features) && $data->features === [])) {
            throw new NotFound();
        }

        return $data;
    }
}
