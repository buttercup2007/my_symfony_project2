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
                w.compnummer,
                w.wedstrijdnummer,
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

                c1.naam AS team1,
                c2.naam AS team2,

                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            LEFT JOIN clubs c1
                ON TRIM(w.club1nummer) = TRIM(c1.clubnummer)

            LEFT JOIN clubs c2
                ON TRIM(w.club2nummer) = TRIM(c2.clubnummer)

            ORDER BY w.datum, w.tijd
        ');
    }

    public function getOntbrekendeUitslagen(
        string $startDatum,
        string $eindDatum
    ): array {
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

                c1.naam AS team1,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2,
                c2.naam AS team2

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            LEFT JOIN clubs c1
                ON TRIM(w.club1nummer) = TRIM(c1.clubnummer)

            LEFT JOIN clubs c2
                ON TRIM(w.club2nummer) = TRIM(c2.clubnummer)

            WHERE w.datum BETWEEN ? AND ?

            AND w.datum <= CURRENT_DATE()

            AND (
                w.puntenteam1 IS NULL
                OR w.puntenteam2 IS NULL
                OR TRIM(w.puntenteam1) = \'\'
                OR TRIM(w.puntenteam2) = \'\'
            )

            ORDER BY w.datum, w.tijd
        ', [$startDatum, $eindDatum]);
    }

    public function getAantalOntbrekendeUitslagen(
        string $startDatum,
        string $eindDatum
    ): array {
        return $this->connection->fetchAllAssociative('
            SELECT
                s.sportnaam AS sport,
                COUNT(*) AS aantal

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            WHERE w.datum BETWEEN ? AND ?

              AND w.datum <= CURRENT_DATE()

              AND (
                  w.puntenteam1 IS NULL
                  OR w.puntenteam2 IS NULL
                  OR TRIM(w.puntenteam1) = \'\'
                  OR TRIM(w.puntenteam2) = \'\'
              )

            GROUP BY s.sportnaam

            ORDER BY s.sportnaam
        ', [
            $startDatum,
            $eindDatum
        ]);
    }

    public function getWeekendOverzicht(
        string $startDatum,
        string $eindDatum,
        ?string $sport = null
    ): array {
        $sql = '
            SELECT
                s.sportnaam AS sport,

                COUNT(*) AS aantal_wedstrijden,

                SUM(
                    CASE
                        WHEN w.datum <= CURRENT_DATE()
                         AND (
                            w.puntenteam1 IS NULL
                            OR w.puntenteam2 IS NULL
                            OR TRIM(w.puntenteam1) = \'\'
                            OR TRIM(w.puntenteam2) = \'\'
                         )
                        THEN 1
                        ELSE 0
                    END
                ) AS aantal_ontbrekend

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            WHERE w.datum BETWEEN ? AND ?';

        $params = [$startDatum, $eindDatum];

        if ($sport !== null && $sport !== '' && $sport !== 'Alle') {
            $sql .= ' AND s.sportnaam = ?';
            $params[] = $sport;
        }

        $sql .= '
            GROUP BY s.sportnaam
            ORDER BY s.sportnaam';

        return $this->connection->fetchAllAssociative($sql, $params);
    }

    public function getWeekendWedstrijden(
        string $startDatum,
        string $eindDatum,
        ?string $sport = null
    ): array {
        $sql = '
            SELECT
                w.compnummer,
                w.wedstrijdnummer,

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

                s.sportnaam AS sport,

                c1.naam AS team1,
                c2.naam AS team2,

                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2

            FROM wedstrijd w

            JOIN sporten s
                ON LEFT(w.compnummer, 3) = s.code

            LEFT JOIN clubs c1
                ON TRIM(w.club1nummer) = TRIM(c1.clubnummer)

            LEFT JOIN clubs c2
                ON TRIM(w.club2nummer) = TRIM(c2.clubnummer)

            WHERE w.datum BETWEEN ? AND ?';

        $params = [$startDatum, $eindDatum];

        if ($sport !== null && $sport !== '' && $sport !== 'Alle') {
            $sql .= ' AND s.sportnaam = ?';
            $params[] = $sport;
        }

        $sql .= ' ORDER BY w.datum, w.tijd';

        return $this->connection->fetchAllAssociative($sql, $params);
    }
}