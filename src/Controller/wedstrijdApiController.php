<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class wedstrijdApiController extends AbstractController
{
    #[Route('/api/weekend-overzicht', name: 'api_weekend_overzicht')]
    public function weekendOverzicht(
        WedstrijdService $wedstrijdService
    ): JsonResponse {
        $periode = $wedstrijdService->getWeekendPeriode();
    
        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $periode['startDatum'],
            $periode['eindDatum']
        );
    
        return $this->json([
            'startDatum' => $periode['startDatum'],
            'eindDatum' => $periode['eindDatum'],
            'overzicht' => $overzicht,
        ]);
    }
}