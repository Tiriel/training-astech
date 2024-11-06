<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event_listevent')]
    public function listEvents(EventRepository $repository): Response
    {
        $events = $repository->findAll();
        $list = \array_map(
            fn(Event $e) => ['id' => $e->getId(), 'name' => $e->getName()],
            $events
        );

        return $this->json($list);
    }

    #[Route('/event/{name}/{start}/{end}', name: 'app_event_new', requirements: ['start' => '[0-9-]{10}', 'end' => '[0-9-]{10}'])]
    public function newEvent(string $name, string $start, string $end, EntityManagerInterface $manager): Response
    {
        $event = (new Event())
            ->setName($name)
            ->setDescription('Some generic description')
            ->setAccessible(true)
            ->setStartAt(new \DateTimeImmutable($start))
            ->setEndAt(new \DateTimeImmutable($end))
        ;

        $manager->persist($event);
        $manager->flush();

        return new Response('Event created');
    }
}
