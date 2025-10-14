<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014160047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz ADD created_by_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_A412FA92B03A8386 ON quiz (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92B03A8386');
        $this->addSql('DROP INDEX IDX_A412FA92B03A8386 ON quiz');
        $this->addSql('ALTER TABLE quiz DROP created_by_id');
    }
}
