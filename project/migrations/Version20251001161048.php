<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251001161048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_question CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE quiz_id quiz_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE quiz_id quiz_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE owner_id owner_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE current_question_id current_question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session_quiz_question CHANGE quiz_session_id quiz_session_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE quiz_question_id quiz_question_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE user CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE quiz_session_quiz_question CHANGE quiz_session_id quiz_session_id CHAR(36) NOT NULL, CHANGE quiz_question_id quiz_question_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE quiz_question CHANGE id id CHAR(36) NOT NULL, CHANGE quiz_id quiz_id CHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_session CHANGE id id CHAR(36) NOT NULL, CHANGE quiz_id quiz_id CHAR(36) DEFAULT NULL, CHANGE owner_id owner_id CHAR(36) DEFAULT NULL, CHANGE current_question_id current_question_id CHAR(36) DEFAULT NULL');
    }
}
