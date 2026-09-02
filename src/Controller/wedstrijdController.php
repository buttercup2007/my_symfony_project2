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
                s.sportnaam,
                COUNT(*) AS aantal_wedstrijden
            FROM wedstrijd w
            JOIN competities c
                ON w.compnummer = c.compnummer
            JOIN sporten s
                ON c.sportsoort = s.sportsoort
            WHERE w.datum BETWEEN '2026-09-05' AND '2026-09-06'
            GROUP BY s.sportnaam
            ORDER BY aantal_wedstrijden DESC
        ";

        $resultaten = $connection->fetchAllAssociative($sql);

        return $this->render('wedstrijd/index.html.twig', [
            'resultaten' => $resultaten
        ]);
    }
}
