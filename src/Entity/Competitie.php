<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'competities')]
class Competitie
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $compnummer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        name: 'sportsoort',
        referencedColumnName: 'sportsoort',
        nullable: false
    )]
    private ?Sport $sport = null;

    #[ORM\Column(length: 9)]
    private ?string $compseizoen = null;

    #[ORM\Column(length: 30)]
    private ?string $district = null;

    #[ORM\Column(length: 20)]
    private ?string $klasse = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer1 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer2 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer3 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer4 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekStand = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $periodenRek = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $standRek = null;

    #[ORM\Column(length: 30)]
    private ?string $aanduiding = null;

    #[ORM\Column(length: 30)]
    private ?string $extra = null;

    #[ORM\Column(nullable: true)]
    private ?int $naamId = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $correspCode = null;

    #[ORM\Column(nullable: true)]
    private ?int $prioriteit = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPerTeam = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode1 = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode2 = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode3 = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode4 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $sortstring = null;

    #[ORM\Column(nullable: true)]
    private ?int $aantTeams = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $minmaxRek = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode5 = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $aantWedstrPeriode6 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer5 = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $opnRekPer6 = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $knockout = null;
}