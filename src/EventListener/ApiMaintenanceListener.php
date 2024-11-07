<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

final class ApiMaintenanceListener
{
    public function __construct(
        protected readonly Environment $twig,
    ) {
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 10)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ('app_event_search' === $request->attributes->get('_route')) {
            $response = new Response($this->twig->render('api_maintenance.html.twig'), 500);
            $event->setResponse($response);
        }
    }
}
