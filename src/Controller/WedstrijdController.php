<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class WedstrijdController extends AbstractController
{
    #[Route('/ontbrekende-uitslagen')]
    public function ontbrekendeUitslagen(
        WedstrijdService $wedstrijdService
    ): Response {
    $wedstrijden = $wedstrijdService->getOntbrekendeUitslagen();
    
    return $this->render('wedstrijd/ontbrekende.html.twig', [
            'wedstrijden' => $wedstrijden,
        ]);
    }
}