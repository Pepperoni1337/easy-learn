<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251004164842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_level DROP FOREIGN KEY FK_6B2EA6D42850CBE3');
        $this->addSql('ALTER TABLE quiz_session_level ADD CONSTRAINT FK_6B2EA6D42850CBE3 FOREIGN KEY (quiz_session_id) REFERENCES quiz_session (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_level DROP FOREIGN KEY FK_6B2EA6D42850CBE3');
        $this->addSql('ALTER TABLE quiz_session_level ADD CONSTRAINT FK_6B2EA6D42850CBE3 FOREIGN KEY (quiz_session_id) REFERENCES quiz_session (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
