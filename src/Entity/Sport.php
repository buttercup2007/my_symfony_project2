<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sporten')]
class Sport
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $sportsoort;

    #[ORM\Column(type: 'string', length: 255)]
    private string $sportnaam;

    public function getSportsoort(): int
    {
        return $this->sportsoort;
    }

    public function setSportsoort(int $sportsoort): self
    {
        $this->sportsoort = $sportsoort;
        return $this;
    }

    public function getSportnaam(): string
    {
        return $this->sportnaam;
    }

    public function setSportnaam(string $sportnaam): self
    {
        $this->sportnaam = $sportnaam;
        return $this;
    }
}
