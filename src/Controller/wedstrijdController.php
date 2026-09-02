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
                COUNT(w.wedstrijdnummer) AS aantal_wedstrijden
            FROM sporten s
            LEFT JOIN competities c
                ON s.sportsoort = c.sportsoort
            LEFT JOIN wedstrijd w
                ON c.compnummer = w.compnummer
            GROUP BY s.sportnaam
            ORDER BY aantal_wedstrijden DESC
        ";

        $resultaten = $connection->fetchAllAssociative($sql);

        return $this->render('wedstrijd/index.html.twig', [
            'resultaten' => $resultaten
        ]);
    }
}