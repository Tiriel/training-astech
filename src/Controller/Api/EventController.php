<?php

namespace App\Controller\Api;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EventController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/event', name: 'app_api_get_events')]
    public function getEventsApi(
        Request $request,
        EventRepository $repository,
        SerializerInterface $serializer
    ): JsonResponse {
        $limit = 20;
        $page = $request->query->getInt('page', 1);
        $events = $repository->findBy([], [], $limit, $limit * ($page - 1));

        $context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER
                => fn(object $object, string $format, array $context) => $object->getId(),
        ];
        $data = $serializer->serialize($events, 'json', $context);

        return new JsonResponse($data, json: true);
    }
}
