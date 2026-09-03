<?php

namespace App\Controller;

use App\Services\WedstrijdService;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class wedstrijdApiController 
{

    #[Route('/api/wedstrijden', methods: ['GET'])]
    public function getCollection(WedstrijdService $wedstrijdService): JsonResponse
    {
        $wedstrijden = $wedstrijdService->getWedstrijden();

        return new JsonResponse($wedstrijden);

    }
}

?>
 