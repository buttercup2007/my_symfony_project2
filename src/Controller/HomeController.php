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
        // Alle wedstrijden waarvan de uitslag compleet is
        $wedstrijdenSql = "
            SELECT COUNT(*) AS aantal
            FROM wedstrijd
            WHERE puntenteam1 IS NOT NULL
              AND puntenteam2 IS NOT NULL
        ";

        $wedstrijden = $connection->fetchOne($wedstrijdenSql);

        // Wedstrijden waarvan de uitslag ontbreekt
        $ontbrekendeSql = "
            SELECT COUNT(*) AS aantal
            FROM wedstrijd
            WHERE puntenteam1 IS NULL
               OR puntenteam2 IS NULL
        ";

        $ontbrekende = $connection->fetchOne($ontbrekendeSql);

        return $this->render('home/index.html.twig', [
            'appName' => 'Symfony + Vue',
            'features' => ['Routing', 'Templates', 'Components'],
            'wedstrijden' => $wedstrijden,
            'ontbrekende' => $ontbrekende,
        ]);
    }
}