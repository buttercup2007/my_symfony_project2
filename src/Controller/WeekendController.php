<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeekendController extends AbstractController
{
    #[Route('/weekend', name: 'app_weekend')]
    public function index(
        Request $request,
        WedstrijdService $wedstrijdService
    ): Response
    {
        $weekendOffset = $request->query->getInt('weekend', 0);
        $wedstrijden = $wedstrijdService->getWedstrijden();
        $vandaag = new \DateTime();

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

        $dagenSindsVrijdag = ((int) $vandaag->format('N') + 2) % 7;
        $startDatum = (clone $vandaag)
            ->modify("-{$dagenSindsVrijdag} days")
            ->modify("{$weekendOffset} weeks");
        $eindDatum = (clone $startDatum)->modify('+2 days');

        $startDatumTekst = $startDatum->format('Y-m-d');
        $eindDatumTekst = $eindDatum->format('Y-m-d');

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatumTekst,
            $eindDatumTekst
        );

        $aantalScores = 0;

        foreach ($wedstrijden as $wedstrijd) {
            if (
                $wedstrijd['datum'] >= $startDatumTekst
                && $wedstrijd['datum'] <= $eindDatumTekst
                && $wedstrijd['score1'] !== null
                && $wedstrijd['score2'] !== null
            ) {
                $aantalScores++;
            }
        }

        return $this->render('weekend/index.html.twig', [
            'overzicht' => $overzicht,
            'wedstrijden' => $wedstrijden,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
            'weekendOffset' => $weekendOffset,
            'aantalScores' => $aantalScores,
        ]);
    }
}