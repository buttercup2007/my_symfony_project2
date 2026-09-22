<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WedstrijdDetailController extends AbstractController
{
    #[Route(
        '/wedstrijd/{compnummer}/{wedstrijdnummer}',
        name: 'wedstrijd_detail'
    )]
    public function detail(
        string $compnummer,
        string $wedstrijdnummer,
        WedstrijdService $wedstrijdService
    ): Response {
        $wedstrijd = $wedstrijdService->getWedstrijd(
            $compnummer,
            $wedstrijdnummer
        );

        if ($wedstrijd === null) {
            throw $this->createNotFoundException(
                'Wedstrijd niet gevonden.'
            );
        }

        return $this->render('wedstrijd/detail.html.twig', [
            'wedstrijd' => $wedstrijd,
        ]);
    }
}