<?php

declare(strict_types=1);

namespace ForumifyDonationsPluginMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240514144305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'remove currency and add override paypal button';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation DROP currency');
        $this->addSql('ALTER TABLE donation_goal ADD paypal_button_id VARCHAR(255) DEFAULT NULL, DROP currency');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation ADD currency VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE donation_goal ADD currency VARCHAR(255) NOT NULL, DROP paypal_button_id');
    }
}
