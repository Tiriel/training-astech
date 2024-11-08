<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Search\DatabaseEventSearch;
use App\Search\EventSearchInterface;
use App\Security\Voter\EditionVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event_listevent', methods: ['GET'])]
    public function listEvents(DatabaseEventSearch $search, Request $request): Response
    {
        $events = $search->searchByName($request->query->get('name'));

        return $this->render('event/list_events.html.twig', [
            'events' => $events
        ]);
    }

    #[Route('/event/search', name: 'app_event_search', methods: ['GET'])]
    #[Template('event/list_events.html.twig')]
    public function searchEvents(Request $request, EventSearchInterface $search): array
    {
        $events = $search->searchByName($request->query->get('name'))['hydra:member'];

        return ['events' => $events];
    }

    #[Route('/event/{id}', name: 'app_event_showevent', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showEvent(?Event $event): Response
    {
        return $this->render('event/show_event.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/event/new', name: 'app_event_new')]
    #[Route('/event/{id<\d+>/edit', name: 'app_event_edit')]
    public function newEvent(?Event $event, Request $request, EntityManagerInterface $manager): Response
    {
        if ($event instanceof Event) {
            $this->denyAccessUnlessGranted(EditionVoter::EVENT, $event);
        }

        $event ??= new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($event);
            $manager->flush();

            return $this->redirectToRoute('app_event_showevent', ['id' => $event->getId()]);
        }

        return $this->render('event/new_event.html.twig', [
            'form' => $form,
        ]);
    }
}
