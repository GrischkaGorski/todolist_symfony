<?php

namespace App\Controller;

use App\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// ...

class TodoController extends AbstractController
{
    #[Route('/todo/{id}', name: 'todo_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        // Vérifie si le todo existe
        if (!$todo) {
            throw $this->createNotFoundException(
                'No todo found for id ' . $id
            );
        }

        // Renvoi le titre du todo
        return new Response('Check out this great todo: ' . $todo->getTitle());

// or render a template
// in the template, print things with {{ product.name }}
// return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
