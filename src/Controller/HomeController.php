<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Wedstrijd;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    #[Route('/index', name: 'home_index')]
    #[Route('/test-entity', name: 'test_entity')]
public function testEntity(EntityManagerInterface $entityManager): Response
{
    $wedstrijd = $entityManager
        ->getRepository(Wedstrijd::class)
        ->findOneBy([]);

    dd($wedstrijd);
}
    public function index(WedstrijdService $wedstrijdService): Response
    {
        $wedstrijden = $wedstrijdService->getWedstrijden();

        

        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden
        ]);
    }
}