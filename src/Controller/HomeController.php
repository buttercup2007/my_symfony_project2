<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        WedstrijdService $wedstrijdService
    ): Response {
    
        $vandaag = new \DateTime();
    
        // Find the most recent Friday
        $dagVanDeWeek = (int) $vandaag->format('N');
    
        if ($dagVanDeWeek >= 5) {
            $dagenSindsVrijdag = $dagVanDeWeek - 5;
        } else {
            $dagenSindsVrijdag = $dagVanDeWeek + 2;
        }
    
        $vrijdag = (clone $vandaag)->modify("-{$dagenSindsVrijdag} days");
    
        // The weekend runs from Friday until Sunday
        $startDatum = (clone $vrijdag);
        $eindDatum = (clone $vrijdag)->modify('+2 days');
    
        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum->format('Y-m-d'),
            $eindDatum->format('Y-m-d')
        );
    
        return $this->render('home/index.html.twig', [
            'overzicht' => $overzicht,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
        ]);
    }
}