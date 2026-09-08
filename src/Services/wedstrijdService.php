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
}