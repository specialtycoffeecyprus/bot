<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

use function file_get_contents;

final class ApiClient
{
    public function __invoke(RequestInterface $request): PromiseInterface
    {
        $path = $request->getUri()->getPath();
        $query = $request->getUri()->getQuery();

        $response = match (true) {
            $path === '/cafes' => $this->makeResponse('cafes.json'),
            $path === '/cafes/random' => $this->makeResponse('cafes.random.json'),
            $path === '/cafes/search' && $query === 'q=paul' => $this->makeResponse('cafes.search.found.json'),
            $path === '/cafes/search' => $this->makeResponse('cafes.search.notfound.json'),
            $path === '/cafes/nearest' => $this->makeResponse('cafes.nearest.json'),
            default => $this->makeResponse404(),
        };

        return new FulfilledPromise($response);
    }


    private function makeResponse(string $filename): Response
    {
        return new Response(200, [], file_get_contents(__DIR__.'/Fixtures/'.$filename));
    }


    private function makeResponse404(): Response
    {
        return new Response(404);
    }
}
