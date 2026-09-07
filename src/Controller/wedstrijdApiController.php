<?php

namespace App\Controller;

use App\Entity\Wedstrijd;
use App\Services\WedstrijdService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

    #[Route('/test-repository', name: 'test_repository')]
    public function testRepository(
        EntityManagerInterface $entityManager
    ): Response {
        $wedstrijden = $entityManager
            ->getRepository(Wedstrijd::class)
            ->getWedstrijden();

        dd($wedstrijden);
    }
}