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
                ON LEFT(w.compnummer, 3) = s.code
            ORDER BY w.datum
        ');
    }

    public function getTeamPunten(): array
    {
        return $this->connection->fetchAllAssociative('
            SELECT
                team,
                COUNT(*) AS wedstrijden,
                SUM(winst) AS gewonnen,
                SUM(gelijkspel) AS gelijk,
                SUM(verlies) AS verloren,
                SUM(punten) AS punten
            FROM (
                SELECT
                    club1nummer AS team,
                    CASE
                        WHEN puntenteam1 > puntenteam2 THEN 1
                        ELSE 0
                    END AS winst,
                    CASE
                        WHEN puntenteam1 = puntenteam2 THEN 1
                        ELSE 0
                    END AS gelijkspel,
                    CASE
                        WHEN puntenteam1 < puntenteam2 THEN 1
                        ELSE 0
                    END AS verlies,
                    CASE
                        WHEN puntenteam1 > puntenteam2 THEN 3
                        WHEN puntenteam1 = puntenteam2 THEN 1
                        ELSE 0
                    END AS punten
                FROM wedstrijd
                WHERE meetellen = \'J\'
                  AND puntenteam1 IS NOT NULL
                  AND puntenteam2 IS NOT NULL

                UNION ALL

                SELECT
                    club2nummer AS team,
                    CASE
                        WHEN puntenteam2 > puntenteam1 THEN 1
                        ELSE 0
                    END AS winst,
                    CASE
                        WHEN puntenteam2 = puntenteam1 THEN 1
                        ELSE 0
                    END AS gelijkspel,
                    CASE
                        WHEN puntenteam2 < puntenteam1 THEN 1
                        ELSE 0
                    END AS verlies,
                    CASE
                        WHEN puntenteam2 > puntenteam1 THEN 3
                        WHEN puntenteam2 = puntenteam1 THEN 1
                        ELSE 0
                    END AS punten
                FROM wedstrijd
                WHERE meetellen = \'J\'
                  AND puntenteam1 IS NOT NULL
                  AND puntenteam2 IS NOT NULL
            ) AS resultaten
            GROUP BY team
            ORDER BY punten DESC
        ');
    }
}