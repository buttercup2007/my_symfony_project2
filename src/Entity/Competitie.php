<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'competities')]
class Competitie
{
    #[ORM\Id]
    #[ORM\Column(name: 'compnummer', type: 'string', length: 50)]
    private string $compnummer;

    #[ORM\ManyToOne(targetEntity: Sport::class)]
    #[ORM\JoinColumn(
        name: 'sportsoort',
        referencedColumnName: 'sportsoort',
        nullable: false
    )]
    private Sport $sport;

    #[ORM\Column(name: 'seizoen', type: 'string', length: 20, nullable: true)]
    private ?string $seizoen = null;

    #[ORM\Column(name: 'district', type: 'string', length: 50, nullable: true)]
    private ?string $district = null;

    #[ORM\Column(name: 'klasse', type: 'string', length: 50, nullable: true)]
    private ?string $klasse = null;

    public function getCompnummer(): string
    {
        return $this->compnummer;
    }

    public function setCompnummer(string $compnummer): self
    {
        $this->compnummer = $compnummer;

        return $this;
    }

    public function getSport(): Sport
    {
        return $this->sport;
    }

    public function setSport(Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getSeizoen(): ?string
    {
        return $this->seizoen;
    }

    public function setSeizoen(?string $seizoen): self
    {
        $this->seizoen = $seizoen;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getKlasse(): ?string
    {
        return $this->klasse;
    }

    public function setKlasse(?string $klasse): self
    {
        $this->klasse = $klasse;

        return $this;
    }
}