<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        WedstrijdService $wedstrijdService
    ): Response {
        $wedstrijden = $wedstrijdService->getWedstrijden();

        $wedstrijdTotalen = $wedstrijdService->getWedstrijdTotalen();

        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden,
            'wedstrijdTotalen' => $wedstrijdTotalen,
        ]);
    }
}

