<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260903112000 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Create the wedstrijden table used by the home page';
	}

	public function up(Schema $schema): void
	{
		$this->addSql('CREATE TABLE wedstrijden (id INT AUTO_INCREMENT NOT NULL, sport VARCHAR(255) NOT NULL, team1 VARCHAR(255) NOT NULL, team2 VARCHAR(255) NOT NULL, datum DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
	}

	public function down(Schema $schema): void
	{
		$this->addSql('DROP TABLE wedstrijden');
	}
}