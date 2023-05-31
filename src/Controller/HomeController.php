<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\ActionGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $manager;

    private $action;

    public function __construct(EntityManagerInterface $manager, ActionGenerator $action)
    {
        $this->manager = $manager;

        $this->action = $action;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $array_day = $this->action->getAction();
        $dayDate = $this->action->getAction();
        $hour = $this->action->getAction();

        return $this->render('pages/Home.html.twig',
            [
                '$array_day' => $array_day,
                '$dayDate' => $dayDate,
                '$hour' => $hour,
            ]
        );
    }
}

