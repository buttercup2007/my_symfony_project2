<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(WedstrijdService $wedstrijdService): Response
    {
        $weekend = $wedstrijdService->getWeekendPeriode(0);

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $weekend['startDatum'],
            $weekend['eindDatum']
        );

        $totaalWedstrijden = 0;
        $totaalOntbrekend = 0;

        foreach ($overzicht as $item) {
            $totaalWedstrijden += (int) $item['aantal_wedstrijden'];
            $totaalOntbrekend += (int) $item['aantal_ontbrekend'];
        }

        return $this->render('home/index.html.twig', [
            'overzicht' => $overzicht,
            'startDatum' => new \DateTime($weekend['startDatum']),
            'eindDatum' => new \DateTime($weekend['eindDatum']),
            'totaalWedstrijden' => $totaalWedstrijden,
            'totaalOntbrekend' => $totaalOntbrekend,
            'totaalUitslagen' => $totaalWedstrijden - $totaalOntbrekend,
        ]);
    }
}