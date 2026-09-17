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

        $periode = $wedstrijdService->getWeekendPeriode($weekendOffset);

        $wedstrijden = $wedstrijdService->getWeekendWedstrijden(
            $periode['startDatum'],
            $periode['eindDatum']
        );

        return $this->json([
            'startDatum' => $periode['startDatum'],
            'eindDatum' => $periode['eindDatum'],
            'wedstrijden' => $wedstrijden,
        ]);
    }
}