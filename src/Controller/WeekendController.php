<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeekendController extends AbstractController
{
    #[Route('/weekend', name: 'app_weekend')]
    public function index(): Response
    {
        return $this->render('weekend/index.html.twig');
    }
}