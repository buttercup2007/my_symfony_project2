<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wedstrijd')]
class Wedstrijd
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $compnummer = null;

    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $wedstrijdnummer = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $club1nummer = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $team1aanduiding = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $club2nummer = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $team2aanduiding = null;

    #[ORM\Column(nullable: true)]
    private ?int $puntenteam1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $puntenteam2 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $meetellen = 'J';

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $bijzonderh = '';

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $tijd = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $periode = '0';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $opmerkingen = null;

    #[ORM\Column(nullable: true)]
    private ?int $wedstrijddag = null;

    #[ORM\Column(nullable: true)]
    private ?int $pntminteam1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $pntminteam2 = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $gewijzigd = null;

    #[ORM\Column(nullable: true)]
    private ?int $id = null;
}