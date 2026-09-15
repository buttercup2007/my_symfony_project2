<?php

namespace App\Services;

use App\Repository\WedstrijdRepository;

class WedstrijdService
{
    public function __construct(
        private WedstrijdRepository $wedstrijdRepository
    ) {
    }

    public function getWedstrijden(): array
    {
        return $this->wedstrijdRepository->getWedstrijden();
    }

    public function getOntbrekendeUitslagen(
        string $startDatum,
        string $eindDatum
    ): array {
        return $this->wedstrijdRepository->getOntbrekendeUitslagen(
            $startDatum,
            $eindDatum
        );
    }

    public function getAantalOntbrekendeUitslagen(
        string $startDatum,
        string $eindDatum
    ): array {
        return $this->wedstrijdRepository->getAantalOntbrekendeUitslagen(
            $startDatum,
            $eindDatum
        );
    }

    public function getWeekendOverzicht(
        string $startDatum,
        string $eindDatum
    ): array {
        return $this->wedstrijdRepository->getWeekendOverzicht(
            $startDatum,
            $eindDatum
        );
    }

    public function getWeekendPeriode(int $weekOffset = 0): array
    {
        $vandaag = new \DateTimeImmutable();

        $dag = (int) $vandaag->format('N');

        if ($dag >= 5) {
            // Friday, Saturday or Sunday.
            $vrijdag = $vandaag->modify('-' . ($dag - 5) . ' days');
        } else {
            // Monday through Thursday.
            $vrijdag = $vandaag->modify('-' . ($dag + 2) . ' days');
        }

        $vrijdag = $vrijdag->modify(
            ($weekOffset >= 0 ? '+' : '') . ($weekOffset * 7) . ' days'
        );
        $zondag = $vrijdag->modify('+2 days');

        return [
            'startDatum' => $vrijdag->format('Y-m-d'),
            'eindDatum' => $zondag->format('Y-m-d'),
        ];
    }
}