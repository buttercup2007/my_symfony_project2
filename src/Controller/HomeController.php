<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/index', name: 'home')]
    public function index(WedstrijdService $wedstrijdService): Response
    {
        $wedstrijden = $wedstrijdService->getWedstrijden();

        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden
        ]);
    }
}