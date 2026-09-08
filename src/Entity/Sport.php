<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sporten')]
class Sport
{
    #[ORM\Id]
    #[ORM\Column(length: 30)]
    private ?string $sportsoort = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $telling = null;

    #[ORM\Column(length: 3, unique: true)]
    private ?string $code = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $sportnaam = null;

    public function getSportsoort(): ?string
    {
        return $this->sportsoort;
    }

    public function setSportsoort(string $sportsoort): static
    {
        $this->sportsoort = $sportsoort;

        return $this;
    }

    public function getTelling(): ?string
    {
        return $this->telling;
    }

    public function setTelling(?string $telling): static
    {
        $this->telling = $telling;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSportnaam(): ?string
    {
        return $this->sportnaam;
    }

    public function setSportnaam(?string $sportnaam): static
    {
        $this->sportnaam = $sportnaam;

        return $this;
    }
}