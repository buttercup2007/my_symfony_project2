<?php

namespace App\Repository;

use App\Entity\Wedstrijd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WedstrijdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wedstrijd::class);
    }

    public function getWedstrijden(): array
    {
        return $this->getEntityManager()
            ->getConnection()
            ->fetchAllAssociative("
                SELECT
                    w.datum,
                    CASE
                        WHEN w.tijd LIKE '%:%' THEN w.tijd
                        WHEN LENGTH(TRIM(w.tijd)) = 4
                            THEN CONCAT(
                                LEFT(TRIM(w.tijd), 2),
                                ':',
                                RIGHT(TRIM(w.tijd), 2)
                            )
                        ELSE w.tijd
                    END AS tijd,
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