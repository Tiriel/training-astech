<?php

namespace App\Consumer;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias]
class EventsApiConsumer implements EventSearchInterface
{
    public function __construct(
        protected readonly HttpClientInterface $eventsClient,
    ) {
    }

    public function searchByName(?string $name = null): iterable
    {
        return $this->eventsClient->request('GET', '/events', [
            'query' => ['name' => $name],
        ])->toArray();
    }
}
