<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        private WedstrijdService $wedstrijdService
    ) {
    }

    #[Route('/index', name: 'home')]
    public function index(): Response
    {
        // Get the matches from the database
        $wedstrijden = $this->wedstrijdService->getWedstrijden();

        // Calculate the points for each team
        $teamPunten = $this->wedstrijdService->getTeamPunten();

        // Send both results to the Twig page
        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden,
            'teamPunten' => $teamPunten,
        ]);
    }
}
