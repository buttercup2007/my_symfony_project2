<?php

namespace App\Controller;

use App\Services\WedstrijdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class WedstrijdController extends AbstractController
{
    #[Route('/ontbrekende-uitslagen', name: 'app_wedstrijd_ontbrekende_uitslagen')]
    public function ontbrekendeUitslagen(
        Request $request,
        WedstrijdService $wedstrijdService

    ): Response {
    $startDatum = $request->query->get('start', '2024-01-01');
    $eindDatum = $request->query->get('eind', '2024-12-31');
    
    $wedstrijden = $wedstrijdService->getOntbrekendeUitslagen($startDatum, $eindDatum);

    return $this->render('wedstrijd/ontbrekende.html.twig', [
            'wedstrijden' => $wedstrijden,
            'startDatum' => $startDatum,
            'eindDatum' => $eindDatum,
        ]);
    }
}