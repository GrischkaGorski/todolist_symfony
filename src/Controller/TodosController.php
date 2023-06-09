<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodosController extends AbstractController
{
    #[Route('/todos', name: 'todos_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $todos = $entityManager->getRepository(Todo::class)->findAll();

        // Vérifie si la liste des todos est vide
        if (empty($todos)) {
            throw $this->createNotFoundException('No todos found');
        }

        // Crée une chaîne pour afficher les titres de tous les todos
        $todosList = '<ul>';
        foreach ($todos as $todo) {
            $todosList .= '<li>' . $todo->getTitle() . '</li>';
        }
        $todosList .= '</ul>';

        return new Response('<h1>Liste des Todos</h1>' . $todosList);
    }
}
