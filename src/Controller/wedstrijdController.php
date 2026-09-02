<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WedstrijdController extends AbstractController
{
    #[Route('/wedstrijden', name: 'wedstrijden')]
    public function wedstrijden(Connection $connection): Response
    {
        $sql = "
            SELECT
                s.sportnaam AS sportnaam,
                w.wedstrijdnummer AS wedstrijdnummer,
                w.datum AS datum,
                w.tijd AS tijd,
                w.club1nummer AS team1,
                w.club2nummer AS team2,
                w.puntenteam1 AS score1,
                w.puntenteam2 AS score2
            FROM wedstrijd w
            JOIN competities c
                ON w.compnummer = c.compnummer
            JOIN sporten s
                ON c.sportsoort = s.sportsoort
            WHERE w.datum >= '2026-09-02'
            ORDER BY w.datum, w.tijd
        ";

        $wedstrijden = $connection->fetchAllAssociative($sql);

        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijden' => $wedstrijden
        ]);
    }
}