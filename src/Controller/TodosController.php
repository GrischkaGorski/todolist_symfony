<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/', name: 'todos_list')]
    public function todos(TodoRepository $todoRepository): Response
    {
        $todos = $todoRepository->showTodos();

        return $this->render('todos/index.html.twig', [
            'todos' => $todos
        ]);
    }

    #[Route('/todos/create', name: 'create_todo')]
    public function createTodo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $todo = new Todo();

        $form = $this->createForm(TodoType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $todo = $form->getData();

            $entityManager->persist($todo);
            dump($todo);
            $entityManager->flush();

            return $this->redirectToRoute('todos_list');
        }

        return $this->render('todos/create.html.twig', ['form' => $form]);
    }

    #[Route('/todos/delete/done', name: 'delete_done')]
    public function deleteDone(TodoRepository $todoRepository): Response {
        $todoRepository->deleteDoneTodos();
        return $this->json(['message' => 'Les tâches terminées ont été supprimées avec succès.']);
    }
}

