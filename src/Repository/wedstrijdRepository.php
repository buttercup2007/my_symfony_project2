<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class WedstrijdRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function getWedstrijden(): array
    {
        return $this->connection->fetchAllAssociative('
            SELECT
                w.datum,
                CASE
                    WHEN w.tijd LIKE \'%:%\' THEN w.tijd
                    WHEN LENGTH(TRIM(w.tijd)) = 4
                        THEN CONCAT(
                            LEFT(TRIM(w.tijd), 2),
                            \':\',
                            RIGHT(TRIM(w.tijd), 2)
                        )
                    ELSE w.tijd
                END AS tijd,
                s.sportsoort
            FROM wedstrijd w
            JOIN sporten s
                ON LEFT(TRIM(w.compnummer), 3) = s.code
            ORDER BY w.datum
        ');
    }
}