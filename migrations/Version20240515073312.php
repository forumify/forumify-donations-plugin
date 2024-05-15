<?php

declare(strict_types=1);

namespace ForumifyDonationsPluginMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240515073312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'make transaction id optional';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation CHANGE transaction_id transaction_id VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation CHANGE transaction_id transaction_id VARCHAR(255) NOT NULL');
    }
}
