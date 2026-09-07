<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wedstrijd')]
class Wedstrijd
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 20, options: ['fixed' => true])]
    private ?string $compnummer = null;

    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 20, options: ['fixed' => true])]
    private ?string $wedstrijdnummer = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true, options: ['fixed' => true])]
    private ?string $club1nummer = null;

    #[ORM\Column(type: 'string', length: 15, nullable: true, options: ['fixed' => true])]
    private ?string $team1aanduiding = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true, options: ['fixed' => true])]
    private ?string $club2nummer = null;

    #[ORM\Column(type: 'string', length: 15, nullable: true, options: ['fixed' => true])]
    private ?string $team2aanduiding = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $puntenteam1 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $puntenteam2 = null;

    #[ORM\Column(type: 'string', length: 1, nullable: true, options: ['fixed' => true, 'default' => 'J'])]
    private ?string $meetellen = 'J';

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\Column(type: 'string', length: 30, nullable: true, options: ['fixed' => true, 'default' => ''])]
    private ?string $bijzonderh = '';

    #[ORM\Column(type: 'string', length: 5, nullable: true, options: ['fixed' => true])]
    private ?string $tijd = null;

    #[ORM\Column(type: 'string', length: 1, nullable: true, options: ['fixed' => true, 'default' => '0'])]
    private ?string $periode = '0';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $opmerkingen = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $wedstrijddag = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $pntminteam1 = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $pntminteam2 = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $gewijzigd = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $id = null;


    public function getCompnummer(): ?string
    {
        return $this->compnummer;
    }

    public function setCompnummer(string $compnummer): static
    {
        $this->compnummer = $compnummer;

        return $this;
    }

    public function getWedstrijdnummer(): ?string
    {
        return $this->wedstrijdnummer;
    }

    public function setWedstrijdnummer(string $wedstrijdnummer): static
    {
        $this->wedstrijdnummer = $wedstrijdnummer;

        return $this;
    }

    public function getClub1nummer(): ?string
    {
        return $this->club1nummer;
    }

    public function setClub1nummer(?string $club1nummer): static
    {
        $this->club1nummer = $club1nummer;

        return $this;
    }

    public function getTeam1aanduiding(): ?string
    {
        return $this->team1aanduiding;
    }

    public function setTeam1aanduiding(?string $team1aanduiding): static
    {
        $this->team1aanduiding = $team1aanduiding;

        return $this;
    }

    public function getClub2nummer(): ?string
    {
        return $this->club2nummer;
    }

    public function setClub2nummer(?string $club2nummer): static
    {
        $this->club2nummer = $club2nummer;

        return $this;
    }

    public function getTeam2aanduiding(): ?string
    {
        return $this->team2aanduiding;
    }

    public function setTeam2aanduiding(?string $team2aanduiding): static
    {
        $this->team2aanduiding = $team2aanduiding;

        return $this;
    }

    public function getPuntenteam1(): ?int
    {
        return $this->puntenteam1;
    }

    public function setPuntenteam1(?int $puntenteam1): static
    {
        $this->puntenteam1 = $puntenteam1;

        return $this;
    }

    public function getPuntenteam2(): ?int
    {
        return $this->puntenteam2;
    }

    public function setPuntenteam2(?int $puntenteam2): static
    {
        $this->puntenteam2 = $puntenteam2;

        return $this;
    }

    public function getMeetellen(): ?string
    {
        return $this->meetellen;
    }

    public function setMeetellen(?string $meetellen): static
    {
        $this->meetellen = $meetellen;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): static
    {
        $this->datum = $datum;

        return $this;
    }

    public function getBijzonderh(): ?string
    {
        return $this->bijzonderh;
    }

    public function setBijzonderh(?string $bijzonderh): static
    {
        $this->bijzonderh = $bijzonderh;

        return $this;
    }

    public function getTijd(): ?string
    {
        return $this->tijd;
    }

    public function setTijd(?string $tijd): static
    {
        $this->tijd = $tijd;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(?string $periode): static
    {
        $this->periode = $periode;

        return $this;
    }

    public function getOpmerkingen(): ?string
    {
        return $this->opmerkingen;
    }

    public function setOpmerkingen(?string $opmerkingen): static
    {
        $this->opmerkingen = $opmerkingen;

        return $this;
    }

    public function getWedstrijddag(): ?int
    {
        return $this->wedstrijddag;
    }

    public function setWedstrijddag(?int $wedstrijddag): static
    {
        $this->wedstrijddag = $wedstrijddag;

        return $this;
    }

    public function getPntminteam1(): ?int
    {
        return $this->pntminteam1;
    }

    public function setPntminteam1(?int $pntminteam1): static
    {
        $this->pntminteam1 = $pntminteam1;

        return $this;
    }

    public function getPntminteam2(): ?int
    {
        return $this->pntminteam2;
    }

    public function setPntminteam2(?int $pntminteam2): static
    {
        $this->pntminteam2 = $pntminteam2;

        return $this;
    }

    public function getGewijzigd(): ?\DateTimeInterface
    {
        return $this->gewijzigd;
    }

    public function setGewijzigd(?\DateTimeInterface $gewijzigd): static
    {
        $this->gewijzigd = $gewijzigd;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }
}