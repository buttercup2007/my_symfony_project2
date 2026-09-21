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
        $selectedSport = $request->query->get('sport', 'Alle');
        $vandaag = new \DateTime();
        $wedstrijden = $wedstrijdService->getWedstrijden();

        $sportOptions = [];
        foreach ($wedstrijden as $wedstrijd) {
            $sport = $wedstrijd['sport'] ?? null;
            if ($sport !== null && $sport !== '') {
                $sportOptions[$sport] = $sport;
            }
        }
        ksort($sportOptions);

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

        $dagVanDeWeek = (int) $vandaag->format('N');

        if ($dagVanDeWeek >= 5) {
            $dagenSindsVrijdag = $dagVanDeWeek - 5;
        } else {
            $dagenSindsVrijdag = $dagVanDeWeek + 2;
        }

        $vrijdag = (clone $vandaag)->modify("-{$dagenSindsVrijdag} days");
        $vrijdag->modify("{$weekendOffset} weeks");

        $startDatum = (clone $vrijdag);
        $eindDatum = (clone $vrijdag)->modify('+2 days');

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum->format('Y-m-d'),
            $eindDatum->format('Y-m-d'),
            $selectedSport !== 'Alle' ? $selectedSport : null
        );

        $filteredWedstrijden = $wedstrijden;
        if ($selectedSport !== 'Alle' && $selectedSport !== null && $selectedSport !== '') {
            $filteredWedstrijden = array_values(array_filter(
                $wedstrijden,
                static fn (array $wedstrijd): bool => ($wedstrijd['sport'] ?? '') === $selectedSport
            ));
        }

        $aantalScores = 0;
        foreach ($filteredWedstrijden as $wedstrijd) {
            if (
                $wedstrijd['datum'] >= $startDatum->format('Y-m-d')
                && $wedstrijd['datum'] <= $eindDatum->format('Y-m-d')
                && $wedstrijd['score1'] !== null
                && $wedstrijd['score2'] !== null
            ) {
                $aantalScores++;
            }
        }

        return $this->render('home/index.html.twig', [
            'overzicht' => $overzicht,
            'wedstrijden' => $filteredWedstrijden,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
            'weekendOffset' => $weekendOffset,
            'selectedSport' => $selectedSport,
            'sportOptions' => $sportOptions,
            'aantalScores' => $aantalScores,
        ]);
    }
}