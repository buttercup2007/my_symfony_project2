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


    public function getCompnummer(): ?string
    {
        return $this->compnummer;
    }

    public function setCompnummer(string $compnummer): static
    {
        $this->compnummer = $compnummer;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCompseizoen(): ?string
    {
        return $this->compseizoen;
    }

    public function setCompseizoen(string $compseizoen): static
    {
        $this->compseizoen = $compseizoen;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): static
    {
        $this->district = $district;

        return $this;
    }

    public function getKlasse(): ?string
    {
        return $this->klasse;
    }

    public function setKlasse(string $klasse): static
    {
        $this->klasse = $klasse;

        return $this;
    }

    public function getOpnRekPer1(): ?string
    {
        return $this->opnRekPer1;
    }

    public function setOpnRekPer1(?string $value): static
    {
        $this->opnRekPer1 = $value;

        return $this;
    }

    public function getOpnRekPer2(): ?string
    {
        return $this->opnRekPer2;
    }

    public function setOpnRekPer2(?string $value): static
    {
        $this->opnRekPer2 = $value;

        return $this;
    }

    public function getOpnRekPer3(): ?string
    {
        return $this->opnRekPer3;
    }

    public function setOpnRekPer3(?string $value): static
    {
        $this->opnRekPer3 = $value;

        return $this;
    }

    public function getOpnRekPer4(): ?string
    {
        return $this->opnRekPer4;
    }

    public function setOpnRekPer4(?string $value): static
    {
        $this->opnRekPer4 = $value;

        return $this;
    }

    public function getOpnRekStand(): ?string
    {
        return $this->opnRekStand;
    }

    public function setOpnRekStand(?string $value): static
    {
        $this->opnRekStand = $value;

        return $this;
    }

    public function getPeriodenRek(): ?string
    {
        return $this->periodenRek;
    }

    public function setPeriodenRek(?string $value): static
    {
        $this->periodenRek = $value;

        return $this;
    }

    public function getStandRek(): ?string
    {
        return $this->standRek;
    }

    public function setStandRek(?string $value): static
    {
        $this->standRek = $value;

        return $this;
    }

    public function getAanduiding(): ?string
    {
        return $this->aanduiding;
    }

    public function setAanduiding(string $value): static
    {
        $this->aanduiding = $value;

        return $this;
    }

    public function getExtra(): ?string
    {
        return $this->extra;
    }

    public function setExtra(string $value): static
    {
        $this->extra = $value;

        return $this;
    }

    public function getNaamId(): ?int
    {
        return $this->naamId;
    }

    public function setNaamId(?int $value): static
    {
        $this->naamId = $value;

        return $this;
    }

    public function getCorrespCode(): ?string
    {
        return $this->correspCode;
    }

    public function setCorrespCode(?string $value): static
    {
        $this->correspCode = $value;

        return $this;
    }

    public function getPrioriteit(): ?int
    {
        return $this->prioriteit;
    }

    public function setPrioriteit(?int $value): static
    {
        $this->prioriteit = $value;

        return $this;
    }

    public function getAantWedstrPerTeam(): ?string
    {
        return $this->aantWedstrPerTeam;
    }

    public function setAantWedstrPerTeam(?string $value): static
    {
        $this->aantWedstrPerTeam = $value;

        return $this;
    }

    public function getAantWedstrPeriode1(): ?string
    {
        return $this->aantWedstrPeriode1;
    }

    public function setAantWedstrPeriode1(?string $value): static
    {
        $this->aantWedstrPeriode1 = $value;

        return $this;
    }

    public function getAantWedstrPeriode2(): ?string
    {
        return $this->aantWedstrPeriode2;
    }

    public function setAantWedstrPeriode2(?string $value): static
    {
        $this->aantWedstrPeriode2 = $value;

        return $this;
    }

    public function getAantWedstrPeriode3(): ?string
    {
        return $this->aantWedstrPeriode3;
    }

    public function setAantWedstrPeriode3(?string $value): static
    {
        $this->aantWedstrPeriode3 = $value;

        return $this;
    }

    public function getAantWedstrPeriode4(): ?string
    {
        return $this->aantWedstrPeriode4;
    }

    public function setAantWedstrPeriode4(?string $value): static
    {
        $this->aantWedstrPeriode4 = $value;

        return $this;
    }

    public function getSortstring(): ?string
    {
        return $this->sortstring;
    }

    public function setSortstring(?string $value): static
    {
        $this->sortstring = $value;

        return $this;
    }

    public function getAantTeams(): ?int
    {
        return $this->aantTeams;
    }

    public function setAantTeams(?int $value): static
    {
        $this->aantTeams = $value;

        return $this;
    }

    public function getMinmaxRek(): ?string
    {
        return $this->minmaxRek;
    }

    public function setMinmaxRek(?string $value): static
    {
        $this->minmaxRek = $value;

        return $this;
    }

    public function getAantWedstrPeriode5(): ?string
    {
        return $this->aantWedstrPeriode5;
    }

    public function setAantWedstrPeriode5(?string $value): static
    {
        $this->aantWedstrPeriode5 = $value;

        return $this;
    }

    public function getAantWedstrPeriode6(): ?string
    {
        return $this->aantWedstrPeriode6;
    }

    public function setAantWedstrPeriode6(?string $value): static
    {
        $this->aantWedstrPeriode6 = $value;

        return $this;
    }

    public function getOpnRekPer5(): ?string
    {
        return $this->opnRekPer5;
    }

    public function setOpnRekPer5(?string $value): static
    {
        $this->opnRekPer5 = $value;

        return $this;
    }

    public function getOpnRekPer6(): ?string
    {
        return $this->opnRekPer6;
    }

    public function setOpnRekPer6(?string $value): static
    {
        $this->opnRekPer6 = $value;

        return $this;
    }

    public function getKnockout(): ?string
    {
        return $this->knockout;
    }

    public function setKnockout(?string $value): static
    {
        $this->knockout = $value;

        return $this;
    }
}

