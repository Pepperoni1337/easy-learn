<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251113190611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD progress_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64943DB87C9 FOREIGN KEY (progress_id) REFERENCES user_progress (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64943DB87C9 ON user (progress_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64943DB87C9');
        $this->addSql('DROP INDEX UNIQ_8D93D64943DB87C9 ON user');
        $this->addSql('ALTER TABLE user DROP progress_id');
    }
}
