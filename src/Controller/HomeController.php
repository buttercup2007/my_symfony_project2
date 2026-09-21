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
        $selectedDate = $request->query->get('date', 'Alle');
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

        $dateOptions = [];
        $periode = new \DatePeriod(
            (clone $startDatum),
            new \DateInterval('P1D'),
            (clone $eindDatum)->modify('+1 day')
        );

        foreach ($periode as $datum) {
            $dateOptions[] = $datum->format('Y-m-d');
        }

        if (!in_array($selectedDate, $dateOptions, true)) {
            $selectedDate = 'Alle';
        }

        $overzicht = $wedstrijdService->getWeekendOverzicht(
            $startDatum->format('Y-m-d'),
            $eindDatum->format('Y-m-d'),
            $selectedSport !== 'Alle' ? $selectedSport : null
        );

        $filteredWedstrijden = $wedstrijden;
        if ($selectedSport !== 'Alle' && $selectedSport !== null && $selectedSport !== '') {
            $filteredWedstrijden = array_values(array_filter(
                $filteredWedstrijden,
                static fn (array $wedstrijd): bool => ($wedstrijd['sport'] ?? '') === $selectedSport
            ));
        }

        if ($selectedDate !== 'Alle' && $selectedDate !== null && $selectedDate !== '') {
            $filteredWedstrijden = array_values(array_filter(
                $filteredWedstrijden,
                static fn (array $wedstrijd): bool => ($wedstrijd['datum'] ?? '') === $selectedDate
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
            'selectedDate' => $selectedDate,
            'sportOptions' => $sportOptions,
            'dateOptions' => $dateOptions,
            'aantalScores' => $aantalScores,
        ]);
    }
}