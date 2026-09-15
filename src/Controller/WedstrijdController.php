<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class WedstrijdController extends AbstractController
{
    #[Route('/ontbrekende-uitslagen', name: 'app_wedstrijd_ontbrekende_uitslagen')]
    public function ontbrekendeUitslagen(
        Request $request,
        WedstrijdService $wedstrijdService
    ): Response {
        $weekOffset = (int) $request->query->get('weekOffset', 0);
        $periode = $wedstrijdService->getWeekendPeriode($weekOffset);

        $startDatum = $periode['startDatum'];
        $eindDatum = $periode['eindDatum'];

        $wedstrijden = $wedstrijdService->getOntbrekendeUitslagen(
            $startDatum,
            $eindDatum
        );

        $aantallen = $wedstrijdService->getAantalOntbrekendeUitslagen(
            $startDatum,
            $eindDatum
        );

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum,
            $eindDatum
        );

        return $this->render('wedstrijd/ontbrekende.html.twig', [
            'wedstrijden' => $wedstrijden,
            'aantallen' => $aantallen,
            'overzicht' => $overzicht,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
            'weekOffset' => $weekOffset,
        ]);
    }
}