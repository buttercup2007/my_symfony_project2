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

    public function getOntbrekendeUitslagen(string $startDatum, string $eindDatum): array
    {
        return $this->wedstrijdRepository->getOntbrekendeUitslagen($startDatum, $eindDatum);
    }

    public function getWedstrijdTotalen(): array
    {
        return $this->wedstrijdRepository->getWedstrijdTotalen();
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
}