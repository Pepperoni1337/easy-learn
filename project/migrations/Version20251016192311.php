<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251016192311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_session_result (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', session_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', UNIQUE INDEX UNIQ_169B526A613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_session_result ADD CONSTRAINT FK_169B526A613FECDF FOREIGN KEY (session_id) REFERENCES quiz_session (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_result DROP FOREIGN KEY FK_169B526A613FECDF');
        $this->addSql('DROP TABLE quiz_session_result');
    }
}
