<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
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

    #[Route('/event/new', name: 'app_event_new')]
    public function newEvent(): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }
}
