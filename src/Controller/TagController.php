<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// ...

class TagController extends AbstractController
{
    #[Route('/tags/{id}', name: 'tag_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $tag = $entityManager->getRepository(Tag::class)->find($id);

        // Vérifie si le todo existe
        if (!$tag) {
            throw $this->createNotFoundException(
                'No tag found for id ' . $id
            );
        }

        // Renvoi le titre du todo
        return new Response('Check out this great tag: ' . $tag->getName());

// or render a template
// in the template, print things with {{ product.name }}
// return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
