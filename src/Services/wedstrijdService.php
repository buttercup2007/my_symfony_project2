<?php

namespace App\Services;

use Doctrine\DBAL\Connection;

class WedstrijdService
{
    public function __construct(
        private Connection $connection
    ) {
    }   
    
    public function getWedstrijden(): array
    {
        return $this->connection->fetchAllAssociative('SELECT * FROM wedstrijden'); 

    }
}














?>