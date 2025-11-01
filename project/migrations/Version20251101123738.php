<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251101123738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_invitation (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_session_progress (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_session_settings (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', keep_wrongly_answered_questions TINYINT(1) DEFAULT 1 NOT NULL, random_order TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_session ADD settings_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', ADD progress_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', DROP score, DROP keep_wrongly_answered_questions');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E787459949888 FOREIGN KEY (settings_id) REFERENCES quiz_session_settings (id)');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E787443DB87C9 FOREIGN KEY (progress_id) REFERENCES quiz_session_progress (id)');
        $this->addSql('CREATE INDEX IDX_C21E787459949888 ON quiz_session (settings_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C21E787443DB87C9 ON quiz_session (progress_id)');
        $this->addSql('ALTER TABLE quiz_session_result ADD quiz_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', CHANGE score total_score INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE quiz_session_result ADD CONSTRAINT FK_169B526A853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_169B526A853CD175 ON quiz_session_result (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E787443DB87C9');
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E787459949888');
        $this->addSql('DROP TABLE quiz_invitation');
        $this->addSql('DROP TABLE quiz_session_progress');
        $this->addSql('DROP TABLE quiz_session_settings');
        $this->addSql('ALTER TABLE quiz_session_result DROP FOREIGN KEY FK_169B526A853CD175');
        $this->addSql('DROP INDEX IDX_169B526A853CD175 ON quiz_session_result');
        $this->addSql('ALTER TABLE quiz_session_result DROP quiz_id, CHANGE total_score score INT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX IDX_C21E787459949888 ON quiz_session');
        $this->addSql('DROP INDEX UNIQ_C21E787443DB87C9 ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session ADD score INT DEFAULT 0 NOT NULL, ADD keep_wrongly_answered_questions TINYINT(1) DEFAULT 1 NOT NULL, DROP settings_id, DROP progress_id');
    }
}
