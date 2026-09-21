<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class wedstrijdApiController extends AbstractController
{
    #[Route('/api/weekend-wedstrijden', name: 'api_weekend_wedstrijden')]
    public function weekendWedstrijden(
        Request $request,
        WedstrijdService $wedstrijdService
    ): JsonResponse {
        $weekendOffset = $request->query->getInt('weekend', 0);
        $sport = $request->query->get('sport');

        $periode = $wedstrijdService->getWeekendPeriode($weekendOffset);

        $wedstrijden = $wedstrijdService->getWeekendWedstrijden(
            $periode['startDatum'],
            $periode['eindDatum'],
            $sport
        );

        return $this->json([
            'startDatum' => $periode['startDatum'],
            'eindDatum' => $periode['eindDatum'],
            'sport' => $sport,
            'wedstrijden' => $wedstrijden,
        ]);
    }

    #[Route('/api/weekend-overzicht', name: 'api_weekend_overzicht')]
    public function weekendOverzicht(
        Request $request,
        WedstrijdService $wedstrijdService
    ): JsonResponse {
        $weekendOffset = $request->query->getInt('weekend', 0);
        $sport = $request->query->get('sport');

        $periode = $wedstrijdService->getWeekendPeriode($weekendOffset);

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $periode['startDatum'],
            $periode['eindDatum'],
            $sport
        );

        return $this->json([
            'startDatum' => $periode['startDatum'],
            'eindDatum' => $periode['eindDatum'],
            'sport' => $sport,
            'overzicht' => $overzicht,
        ]);
    }
}