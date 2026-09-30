<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260929120000 extends AbstractMigration
{
	public function getDescription(): string
	{
		return 'Correct score for FC Dordrecht vs Almere City from 2-2 to 3-2';
	}

	public function up(Schema $schema): void
	{
		$this->addSql("UPDATE wedstrijd SET puntenteam1 = '3' WHERE compnummer = 'vbv-ned-kkd-hxx-xxx' AND wedstrijdnummer = '19715945'");
	}

	public function down(Schema $schema): void
	{
		$this->addSql("UPDATE wedstrijd SET puntenteam1 = '2' WHERE compnummer = 'vbv-ned-kkd-hxx-xxx' AND wedstrijdnummer = '19715945'");
	}
}
