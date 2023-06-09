<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    #[Route('/tags', name: 'tags_show')]
    public function show(EntityManagerInterface $entityManager): Response
    {
        $tags = $entityManager->getRepository(Tag::class)->findAll();

        // Vérifie si la liste des tags est vide
        if (empty($tags)) {
            throw $this->createNotFoundException('No tags found');
        }

        // Crée une chaîne pour afficher les titres de tous les todos
        $tagsList = '<ul>';
        foreach ($tags as $tag) {
            $tagsList .= '<li>' . $tag->getName() . '</li>';
        }
        $tagsList .= '</ul>';

        return new Response('<h1>Liste des tags</h1>' . $tagsList);
    }
}
