<?php

namespace App\EventListener;

use App\Provider\EventProvider;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: KernelEvents::VIEW)]
final class ApiTransformerListener
{

    public function __construct(
        protected readonly EventProvider $provider,
    ) {
    }

    public function __invoke(ViewEvent $event): void
    {
        $request = $event->getRequest();
        if ('app_event_search' !== $request->attributes->get('_route')) {
            return;
        }

        $result = $event->getControllerResult();
        $result['events'] = $this->provider->getFromApiResults($result['events']);

        $event->setControllerResult($result);
    }
}
