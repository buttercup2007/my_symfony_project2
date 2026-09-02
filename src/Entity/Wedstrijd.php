<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'wedstrijd')]
class Wedstrijd
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $wedstrijdid;

    #[ORM\Column(type: 'integer')]
    private int $compnummer;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $datum;

    #[ORM\Column(type: 'string', length: 255)]
    private string $plaats;

    public function getWedstrijdid(): int
    {
        return $this->wedstrijdid;
    }

    public function setWedstrijdid(int $wedstrijdid): self
    {
        $this->wedstrijdid = $wedstrijdid;
        return $this;
    }

    public function getCompnummer(): int
    {
        return $this->compnummer;
    }

    public function setCompnummer(int $compnummer): self
    {
        $this->compnummer = $compnummer;
        return $this;
    }

    public function getDatum(): \DateTime
    {
        return $this->datum;
    }

    public function setDatum(\DateTime $datum): self
    {
        $this->datum = $datum;
        return $this;
    }

    public function getPlaats(): string
    {
        return $this->plaats;
    }

    public function setPlaats(string $plaats): self
    {
        $this->plaats = $plaats;
        return $this;
    }
}
