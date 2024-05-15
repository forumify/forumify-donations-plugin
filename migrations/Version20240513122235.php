<?php

declare(strict_types=1);

namespace ForumifyDonationsPluginMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240513122235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'initial donations schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE donation_donation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, goal_id INT DEFAULT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, transaction_id VARCHAR(255) NOT NULL, amount INT NOT NULL, currency VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FAAE9ED02FC0CB0F (transaction_id), INDEX IDX_FAAE9ED0A76ED395 (user_id), INDEX IDX_FAAE9ED0667D1AFE (goal_id), INDEX IDX_FAAE9ED0DE12AB56 (created_by), INDEX IDX_FAAE9ED016FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation_goal (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, updated_by INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, goal INT NOT NULL, currency VARCHAR(255) NOT NULL, close_when_reached TINYINT(1) NOT NULL, `from` DATE DEFAULT NULL, `to` DATE DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_ED4FC004989D9B62 (slug), INDEX IDX_ED4FC004DE12AB56 (created_by), INDEX IDX_ED4FC00416FE72E1 (updated_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation_donation ADD CONSTRAINT FK_FAAE9ED0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE donation_donation ADD CONSTRAINT FK_FAAE9ED0667D1AFE FOREIGN KEY (goal_id) REFERENCES donation_goal (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE donation_donation ADD CONSTRAINT FK_FAAE9ED0DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE donation_donation ADD CONSTRAINT FK_FAAE9ED016FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE donation_goal ADD CONSTRAINT FK_ED4FC004DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE donation_goal ADD CONSTRAINT FK_ED4FC00416FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE donation_donation DROP FOREIGN KEY FK_FAAE9ED0A76ED395');
        $this->addSql('ALTER TABLE donation_donation DROP FOREIGN KEY FK_FAAE9ED0667D1AFE');
        $this->addSql('ALTER TABLE donation_donation DROP FOREIGN KEY FK_FAAE9ED0DE12AB56');
        $this->addSql('ALTER TABLE donation_donation DROP FOREIGN KEY FK_FAAE9ED016FE72E1');
        $this->addSql('ALTER TABLE donation_goal DROP FOREIGN KEY FK_ED4FC004DE12AB56');
        $this->addSql('ALTER TABLE donation_goal DROP FOREIGN KEY FK_ED4FC00416FE72E1');
        $this->addSql('DROP TABLE donation_donation');
        $this->addSql('DROP TABLE donation_goal');
    }
}
