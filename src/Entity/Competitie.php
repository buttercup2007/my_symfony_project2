<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'competities')]
class Competitie
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $compnummer;

    #[ORM\Column(type: 'integer')]
    private int $sportsoort;

    #[ORM\Column(type: 'string', length: 255)]
    private string $compnaam;

    public function getCompnummer(): int
    {
        return $this->compnummer;
    }

    public function setCompnummer(int $compnummer): self
    {
        $this->compnummer = $compnummer;
        return $this;
    }

    public function getSportsoort(): int
    {
        return $this->sportsoort;
    }

    public function setSportsoort(int $sportsoort): self
    {
        $this->sportsoort = $sportsoort;
        return $this;
    }

    public function getCompnaam(): string
    {
        return $this->compnaam;
    }

    public function setCompnaam(string $compnaam): self
    {
        $this->compnaam = $compnaam;
        return $this;
    }
}
