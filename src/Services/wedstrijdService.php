<?php

namespace App\Services;

use Doctrine\DBAL\Connection;

class WedstrijdService
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getWedstrijden(): array
    {
        return $this->connection->fetchAllAssociative("
            SELECT
                w.datum,
                w.tijd,
                s.sportsoort AS sport,
                w.club1nummer AS team1,
                w.club2nummer AS team2
            FROM wedstrijd w
            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code
            ORDER BY w.datum, w.tijd
        ");
    }
}
