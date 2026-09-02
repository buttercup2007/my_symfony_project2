<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Connection $connection): Response
    {
        // Wedstrijden MET uitslag
        $wedstrijdenSql = "
            SELECT 
                s.sportnaam AS sportnaam,
                w.wedstrijdnummer AS wedstrijdnummer,
                w.datum AS datum,
                w.tijd AS tijd,
                c1.naam AS team1,
                c2.naam AS team2,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2
            FROM wedstrijd w

            JOIN competities c
                ON w.compnummer = c.compnummer

            JOIN sporten s
                ON c.sportsoort = s.sportsoort

            LEFT JOIN clubs c1
                ON w.club1nummer = c1.clubnummer

            LEFT JOIN clubs c2
                ON w.club2nummer = c2.clubnummer

            WHERE w.datum >= '2026-09-02'
            AND w.puntenteam1 IS NOT NULL
            AND w.puntenteam2 IS NOT NULL

            ORDER BY w.datum, w.tijd
        ";

        $wedstrijden = $connection->fetchAllAssociative($wedstrijdenSql);


        // Wedstrijden ZONDER uitslag (ontbrekende iets)
        $ontbrekendeSql = "
            SELECT 
                s.sportnaam AS sportnaam,
                w.wedstrijdnummer AS wedstrijdnummer,
                w.datum AS datum,
                w.tijd AS tijd,
                c1.naam AS team1,
                c2.naam AS team2,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2
            FROM wedstrijd w

            JOIN competities c
                ON w.compnummer = c.compnummer

            JOIN sporten s
                ON c.sportsoort = s.sportsoort

            LEFT JOIN clubs c1
                ON w.club1nummer = c1.clubnummer

            LEFT JOIN clubs c2
                ON w.club2nummer = c2.clubnummer

            WHERE w.datum >= '2026-09-02'

            AND (
                w.puntenteam1 IS NULL
                OR w.puntenteam2 IS NULL
            )

            ORDER BY w.datum, w.tijd
        ";

        $ontbrekende = $connection->fetchAllAssociative($ontbrekendeSql);


        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden,
            'ontbrekende' => $ontbrekende,
        ]);
    }
}
