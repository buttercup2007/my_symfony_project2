<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WedstrijdController extends AbstractController
{
    #[Route('/wedstrijden', name: 'wedstrijden')]
    public function index(WedstrijdService $wedstrijdService): Response
    {
        $wedstrijden = $wedstrijdService->getWedstrijden();

        dd($wedstrijden);

        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijden' => $wedstrijden,
        ]);
    }
}