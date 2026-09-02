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
        // Wedstrijden van het weekend
        $wedstrijdenSql = "
            SELECT
                s.sportnaam AS sportnaam,
                w.wedstrijdnummer AS wedstrijdnummer,
                w.datum AS datum,
                w.club1nummer AS team1,
                w.club2nummer AS team2,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2
            FROM wedstrijd w
            JOIN competities c
                ON w.compnummer = c.compnummer
            JOIN sporten s
                ON c.sportsoort = s.sportsoort
            WHERE w.datum BETWEEN '2026-10-03' AND '2026-10-04'
            ORDER BY w.datum, w.tijd
        ";

        $wedstrijden = $connection->fetchAllAssociative($wedstrijdenSql);


        // Wedstrijden waarvan de uitslag ontbreekt
        $ontbrekendeSql = "
            SELECT
                s.sportnaam AS sportnaam,
                w.wedstrijddag AS wedstrijddag,
                w.datum AS datum,
                w.club1nummer AS team1,
                w.club2nummer AS team2,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2
            FROM wedstrijd w
            JOIN competities c
                ON w.compnummer = c.compnummer
            JOIN sporten s
                ON c.sportsoort = s.sportsoort
            WHERE w.datum BETWEEN '2026-10-03' AND '2026-10-04'
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