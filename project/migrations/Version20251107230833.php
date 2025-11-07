<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251107230833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_progress (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', score INT NOT NULL, level INT NOT NULL, number_of_finished_sessions INT NOT NULL, INDEX IDX_C28C1646A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_progress ADD CONSTRAINT FK_C28C1646A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_progress DROP FOREIGN KEY FK_C28C1646A76ED395');
        $this->addSql('DROP TABLE user_progress');
    }
}
