<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends AbstractController
{
    #[Route('/tags', name: 'tags_list')]
    public function tags(TagRepository $tagRepository): Response
    {
        $tags = $tagRepository->showTags();

        return $this->render('tags/index.html.twig', [
            'tags' => $tags
        ]);
    }

    #[Route('/tags/create', name: 'tags_create')]
    public function createTag(Request $request, EntityManagerInterface $entityManager): Response
    {
        $todo = new Tag();

        $form = $this->createForm(TagType::class, $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $todo = $form->getData();

            $entityManager->persist($todo);
            $entityManager->flush();

            return $this->redirectToRoute('tags_list');
        }

        return $this->render('tags/create.html.twig', ['form' => $form]);
    }
}

