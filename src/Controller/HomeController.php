<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        Request $request,
        WedstrijdService $wedstrijdService
    ): Response {
        $weekendOffset = $request->query->getInt('weekend', 0);
        $vandaag = new \DateTime();
        $wedstrijden = $wedstrijdService->getWedstrijden();

        $laatsteScoreDatum = null;
        foreach ($wedstrijden as $wedstrijd) {
            if ($wedstrijd['score1'] !== null && $wedstrijd['score2'] !== null) {
                $scoreDatum = new \DateTime($wedstrijd['datum']);
                if ($laatsteScoreDatum === null || $scoreDatum > $laatsteScoreDatum) {
                    $laatsteScoreDatum = $scoreDatum;
                }
            }
        }

        if ($laatsteScoreDatum !== null) {
            $vandaag = $laatsteScoreDatum;
        }
    
        // Find the most recent Friday
        $dagVanDeWeek = (int) $vandaag->format('N');
    
        if ($dagVanDeWeek >= 5) {
            $dagenSindsVrijdag = $dagVanDeWeek - 5;
        } else {
            $dagenSindsVrijdag = $dagVanDeWeek + 2;
        }
    
        $vrijdag = (clone $vandaag)->modify("-{$dagenSindsVrijdag} days");
        $vrijdag->modify("{$weekendOffset} weeks");
    
        // The weekend runs from Friday until Sunday
        $startDatum = (clone $vrijdag);
        $eindDatum = (clone $vrijdag)->modify('+2 days');
    
        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum->format('Y-m-d'),
            $eindDatum->format('Y-m-d')
        );

        return $this->render('home/index.html.twig', [
            'overzicht' => $overzicht,
            'wedstrijden' => $wedstrijden,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
            'weekendOffset' => $weekendOffset,
        ]);
    }
}