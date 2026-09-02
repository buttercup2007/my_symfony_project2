<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'clubs')]
class Club
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $clubnummer;

    public function getClubnummer(): int
    {
        return $this->clubnummer;
    }

    public function setClubnummer(int $clubnummer): self
    {
        $this->clubnummer = $clubnummer;
        return $this;
    }
}
