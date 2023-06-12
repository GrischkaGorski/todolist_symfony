<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/todos', name: 'todos_list')]
    public function todos(TodoRepository $todoRepository): Response
    {
        $todos = $todoRepository->showTodos();

        return $this->render('todos/index.html.twig', [
            'todos' => $todos
        ]);
    }

    #[Route('/todos/create', name: 'create_todo')]
    public function createTodo(Request $request): Response
    {
        $todo = new Todo();

        $form = $this->createForm(TodoType::class, $todo);

        return $this->render('todos/create.html.twig', ['form' => $form]);
    }
}

