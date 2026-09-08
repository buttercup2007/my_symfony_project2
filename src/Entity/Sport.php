<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Sport
{
    #[ORM\Id]
    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $sportsoort = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSportsoort(): ?string
    {
        return $this->sportsoort;
    }

    public function setSportsoort(string $sportsoort): static
    {
        $this->sportsoort = $sportsoort;

        return $this;
    }
}