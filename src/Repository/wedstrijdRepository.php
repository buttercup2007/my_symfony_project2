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

                s.sportsoort AS sport,

                w.club1nummer AS team1,
                w.club2nummer AS team2,

                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            ORDER BY w.datum, w.tijd
        ');
    }

    public function getOntbrekendeUitslagen(): array
    {
        return $this->connection->fetchAllAssociative('
            SELECT
                s.sportnaam AS sport,
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
    
                w.club1nummer AS team1,
                w.club2nummer AS team2
    
            FROM wedstrijd w
    
            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code
    
            WHERE w.puntenteam1 IS NULL
               OR w.puntenteam2 IS NULL
    
            ORDER BY w.datum, w.tijd
        ');
    }
}