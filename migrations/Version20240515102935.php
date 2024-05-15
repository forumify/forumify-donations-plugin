<?php

declare(strict_types=1);

namespace ForumifyDonationsPluginMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240515102935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add payload to donations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation ADD payload JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation DROP payload');
    }
}
