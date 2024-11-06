<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event_listevent', methods: ['GET'])]
    public function listEvents(EventRepository $repository): Response
    {
        return $this->render('event/list_events.html.twig', [
            'events' => $repository->findAll(),
        ]);
    }

    #[Route('/event/{id}', name: 'app_event_showevent', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEvent(?Event $event): Response
    {
        return $this->render('event/show_event.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/event/{name}/{start}/{end}', name: 'app_event_new', requirements: ['start' => '[0-9-]{10}', 'end' => '[0-9-]{10}'], methods: ['GET'])]
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
