<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/project', name: 'app_project_listproject', methods: ['GET'])]
    public function listProjects(ProjectRepository $repository): Response
    {
        return $this->render('project/list_projects.html.twig', [
            'projects' => $repository->findAll(),
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_showproject', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProject(?Project $project): Response
    {
        return $this->render('project/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/project/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function newProject(): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);

        return $this->render('project/new_project.html.twig', [
            'form' => $form,
        ]);
    }
}
