<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeekendController extends AbstractController
{
    #[Route('/weekend', name: 'app_weekend')]
    public function index(WedstrijdService $wedstrijdService): Response
    {
        $startDatum = '2026-09-11';
        $eindDatum = '2026-09-13';

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum,
            $eindDatum
        );

        return $this->render('weekend/index.html.twig', [
            'overzicht' => $overzicht,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
        ]);
    }
}