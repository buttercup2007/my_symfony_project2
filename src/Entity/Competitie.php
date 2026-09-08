<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Competitie
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $compnummer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sportsoort = null;

    public function getCompnummer(): ?string
    {
        return $this->compnummer;
    }

    public function setCompnummer(string $compnummer): static
    {
        $this->compnummer = $compnummer;

        return $this;
    }

    public function getSportsoort(): ?string
    {
        return $this->sportsoort;
    }

    public function setSportsoort(?string $sportsoort): static
    {
        $this->sportsoort = $sportsoort;

        return $this;
    }
}