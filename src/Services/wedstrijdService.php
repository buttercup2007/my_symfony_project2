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

    public function getOntbrekendeUitslagen(): array
    {
        return $this->wedstrijdRepository->getOntbrekendeUitslagen();
    }

    public function getTeamPunten(): array
    {
    return $this->wedstrijdRepository->getTeamPunten();
    }
}