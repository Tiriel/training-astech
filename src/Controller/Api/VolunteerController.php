<?php

namespace App\Controller\Api;

use App\Repository\VolunteerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class VolunteerController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED')]
    #[Route('/api/volunteer', name: 'app_api_get_volunteers', methods: ['GET'])]
    public function getVolunteersApi(VolunteerRepository $repository): JsonResponse
    {
        return $this->json($repository->findAll());
    }
}
