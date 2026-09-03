<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/index', name: 'home')]
    public function index(Connection $connection): Response
    {
        $wedstrijden = $connection->fetchAllAssociative('SELECT * FROM wedstrijden');

        return $this->render('home/index.html.twig', [
            'wedstrijden' => $wedstrijden
        ]);
    }
}