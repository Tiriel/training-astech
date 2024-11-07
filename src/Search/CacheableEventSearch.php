<?php

namespace App\Search;

use App\Search\EventSearchInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsDecorator(EventSearchInterface::class)]
class CacheableEventSearch implements EventSearchInterface
{
    public function __construct(
        protected readonly EventSearchInterface $inner,
        protected readonly CacheInterface $cache,
    ) {
    }

    public function searchByName(?string $name = null): iterable
    {
        return $this->cache->get(md5($name ?? 'default_search'), function (ItemInterface $item) use ($name) {
            $item->expiresAfter(3600);

            return $this->inner->searchByName($name);
        });
    }
}
