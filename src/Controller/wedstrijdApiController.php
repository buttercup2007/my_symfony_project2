<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class wedstrijdApiController 
   {
    #[Route('/api/wedstrijden', methods: ['GET'])]
    public function getCollection(Connection $connection): JsonResponse
    {
        $wedstrijden = $connection->fetchAllAssociative(" Select * FROM wedstrijden");

        return new JsonResponse($wedstrijden);
    }
}