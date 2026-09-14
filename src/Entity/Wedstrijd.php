<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wedstrijd')]
class Wedstrijd
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Competitie::class)]
    #[ORM\JoinColumn(
        name: 'compnummer',
        referencedColumnName: 'compnummer',
        nullable: false
    )]
    private Competitie $competitie;

    #[ORM\Id]
    #[ORM\Column(name: 'wedstrijdnummer', type: 'string', length: 50)]
    private string $wedstrijdnummer;

    #[ORM\Column(name: 'club1nummer', type: 'string', length: 50, nullable: true)]
    private ?string $club1nummer = null;

    #[ORM\Column(name: 'club2nummer', type: 'string', length: 50, nullable: true)]
    private ?string $club2nummer = null;

    #[ORM\Column(name: 'puntenteam1', type: 'string', length: 10, nullable: true)]
    private ?string $puntenteam1 = null;

    #[ORM\Column(name: 'puntenteam2', type: 'string', length: 10, nullable: true)]
    private ?string $puntenteam2 = null;

    #[ORM\Column(name: 'meetellen', type: 'string', length: 1, nullable: true)]
    private ?string $meetellen = null;

    #[ORM\Column(name: 'datum', type: 'date', nullable: true)]
    private ?\DateTimeInterface $datum = null;

    #[ORM\Column(name: 'tijd', type: 'string', length: 5, nullable: true)]
    private ?string $tijd = null;

    #[ORM\Column(name: 'bijzonderh', type: 'string', length: 255, nullable: true)]
    private ?string $bijzonderh = null;

    #[ORM\Column(name: 'periode', type: 'string', length: 20, nullable: true)]
    private ?string $periode = null;

    #[ORM\Column(name: 'gewijzigd', type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $gewijzigd = null;

    public function getCompetitie(): Competitie
    {
        return $this->competitie;
    }

    public function setCompetitie(Competitie $competitie): self
    {
        $this->competitie = $competitie;

        return $this;
    }

    public function getWedstrijdnummer(): string
    {
        return $this->wedstrijdnummer;
    }

    public function setWedstrijdnummer(string $wedstrijdnummer): self
    {
        $this->wedstrijdnummer = $wedstrijdnummer;

        return $this;
    }

    public function getClub1nummer(): ?string
    {
        return $this->club1nummer;
    }

    public function setClub1nummer(?string $club1nummer): self
    {
        $this->club1nummer = $club1nummer;

        return $this;
    }

    public function getClub2nummer(): ?string
    {
        return $this->club2nummer;
    }

    public function setClub2nummer(?string $club2nummer): self
    {
        $this->club2nummer = $club2nummer;

        return $this;
    }

    public function getPuntenteam1(): ?string
    {
        return $this->puntenteam1;
    }

    public function setPuntenteam1(?string $puntenteam1): self
    {
        $this->puntenteam1 = $puntenteam1;

        return $this;
    }

    public function getPuntenteam2(): ?string
    {
        return $this->puntenteam2;
    }

    public function setPuntenteam2(?string $puntenteam2): self
    {
        $this->puntenteam2 = $puntenteam2;

        return $this;
    }

    public function getMeetellen(): ?string
    {
        return $this->meetellen;
    }

    public function setMeetellen(?string $meetellen): self
    {
        $this->meetellen = $meetellen;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getTijd(): ?string
    {
        return $this->tijd;
    }

    public function setTijd(?string $tijd): self
    {
        $this->tijd = $tijd;

        return $this;
    }

    public function getBijzonderh(): ?string
    {
        return $this->bijzonderh;
    }

    public function setBijzonderh(?string $bijzonderh): self
    {
        $this->bijzonderh = $bijzonderh;

        return $this;
    }

    public function getPeriode(): ?string
    {
        return $this->periode;
    }

    public function setPeriode(?string $periode): self
    {
        $this->periode = $periode;

        return $this;
    }

    public function getGewijzigd(): ?\DateTimeInterface
    {
        return $this->gewijzigd;
    }

    public function setGewijzigd(?\DateTimeInterface $gewijzigd): self
    {
        $this->gewijzigd = $gewijzigd;

        return $this;
    }
}