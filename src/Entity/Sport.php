<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sporten')]
class Sport
{
    #[ORM\Id]
    #[ORM\Column(name: 'sportsoort', type: 'string', length: 50)]
    private string $sportsoort;

    #[ORM\Column(name: 'code', type: 'string', length: 3, unique: true)]
    private string $code;

    #[ORM\Column(name: 'sportnaam', type: 'string', length: 255)]
    private string $sportnaam;

    public function getSportsoort(): string
    {
        return $this->sportsoort;
    }

    public function setSportsoort(string $sportsoort): self
    {
        $this->sportsoort = $sportsoort;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

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