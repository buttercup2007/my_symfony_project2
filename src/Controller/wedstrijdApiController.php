<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class wedstrijdApiController extends AbstractController
{

    #[Route('/api/wedstrijden', name: 'api_wedstrijden', methods: ['GET'])]
    public function wedstrijden(WedstrijdService $wedstrijdService): JsonResponse
    {
        return $this->json([
            'wedstrijden' => $wedstrijdService->getWedstrijden(),
            'ontbrekendeUitslagen' => $wedstrijdService->getOntbrekendeUitslagen(),
        ]);

    }
}

?>
 