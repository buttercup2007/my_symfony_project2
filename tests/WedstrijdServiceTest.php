<?php

namespace App\Tests;

use App\Repository\WedstrijdRepository;
use App\Services\WedstrijdService;
use PHPUnit\Framework\TestCase;

class WedstrijdServiceTest extends TestCase
{
    public function testGetWeekendOverzichtPassesSportFilter(): void
    {
        $repository = $this->createMock(WedstrijdRepository::class);
        $repository
            ->expects($this->once())
            ->method('getWeekendOverzicht')
            ->with('2026-09-18', '2026-09-20', 'Voetbal')
            ->willReturn([]);

        $service = new WedstrijdService($repository);

        $service->getWeekendOverzicht('2026-09-18', '2026-09-20', 'Voetbal');
    }

    public function testGetWeekendWedstrijdenPassesSportFilter(): void
    {
        $repository = $this->createMock(WedstrijdRepository::class);
        $repository
            ->expects($this->once())
            ->method('getWeekendWedstrijden')
            ->with('2026-09-18', '2026-09-20', 'Basketbal')
            ->willReturn([]);

        $service = new WedstrijdService($repository);

        $service->getWeekendWedstrijden('2026-09-18', '2026-09-20', 'Basketbal');
    }
}
