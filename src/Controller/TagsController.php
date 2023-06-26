<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}

