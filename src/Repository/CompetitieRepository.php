<?php

namespace App\Repository;

use App\Entity\Competitie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CompetitieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competitie::class);
    }

    public function getCompetities(): array
    {
        return $this->findAll();
    }
}