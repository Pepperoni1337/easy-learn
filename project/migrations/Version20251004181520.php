<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251004181520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E7874C2C9318D');
        $this->addSql('DROP INDEX UNIQ_C21E7874C2C9318D ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session DROP current_level_id');
        $this->addSql('ALTER TABLE quiz_session_level DROP FOREIGN KEY FK_6B2EA6D4A0F35D66');
        $this->addSql('DROP INDEX IDX_6B2EA6D4A0F35D66 ON quiz_session_level');
        $this->addSql('ALTER TABLE quiz_session_level DROP current_question_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_level ADD current_question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session_level ADD CONSTRAINT FK_6B2EA6D4A0F35D66 FOREIGN KEY (current_question_id) REFERENCES quiz_question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6B2EA6D4A0F35D66 ON quiz_session_level (current_question_id)');
        $this->addSql('ALTER TABLE quiz_session ADD current_level_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E7874C2C9318D FOREIGN KEY (current_level_id) REFERENCES quiz_session_level (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C21E7874C2C9318D ON quiz_session (current_level_id)');
    }
}
