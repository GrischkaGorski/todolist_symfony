<?php

namespace App\Controller;

use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/', name: 'todos_list')]
    public function todos(TodoRepository $todoRepository): Response
    {
        $todos = $todoRepository->findAll();
        return $this->render('tasks/index.html.twig', ['todos' => $todos]);
    }
}

