<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TasksController extends AbstractController
{
    #[Route('/')]
    public function tasks(): Response
    {
        return $this->render('tasks/index.html.twig', ['tasks' => [ 'Tâche 1', 'Tâche2']]);
    }
}

