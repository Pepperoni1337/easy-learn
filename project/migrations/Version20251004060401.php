<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251004060401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_session_level (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', quiz_session_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', current_question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', level INT NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_6B2EA6D42850CBE3 (quiz_session_id), INDEX IDX_6B2EA6D4A0F35D66 (current_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_session_level_quiz_question (quiz_session_level_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', quiz_question_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', INDEX IDX_43B3F3E4C84A4E17 (quiz_session_level_id), INDEX IDX_43B3F3E43101E51F (quiz_question_id), PRIMARY KEY(quiz_session_level_id, quiz_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_session_level ADD CONSTRAINT FK_6B2EA6D42850CBE3 FOREIGN KEY (quiz_session_id) REFERENCES quiz_session (id)');
        $this->addSql('ALTER TABLE quiz_session_level ADD CONSTRAINT FK_6B2EA6D4A0F35D66 FOREIGN KEY (current_question_id) REFERENCES quiz_question (id)');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question ADD CONSTRAINT FK_43B3F3E4C84A4E17 FOREIGN KEY (quiz_session_level_id) REFERENCES quiz_session_level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question ADD CONSTRAINT FK_43B3F3E43101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_quiz_question DROP FOREIGN KEY FK_C0BBC8C12850CBE3');
        $this->addSql('ALTER TABLE quiz_session_quiz_question DROP FOREIGN KEY FK_C0BBC8C13101E51F');
        $this->addSql('DROP TABLE quiz_session_quiz_question');
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E7874A0F35D66');
        $this->addSql('DROP INDEX IDX_C21E7874A0F35D66 ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session CHANGE current_question_id current_level_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E7874C2C9318D FOREIGN KEY (current_level_id) REFERENCES quiz_session_level (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C21E7874C2C9318D ON quiz_session (current_level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E7874C2C9318D');
        $this->addSql('CREATE TABLE quiz_session_quiz_question (quiz_session_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid_id)\', quiz_question_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid_id)\', INDEX IDX_C0BBC8C12850CBE3 (quiz_session_id), INDEX IDX_C0BBC8C13101E51F (quiz_question_id), PRIMARY KEY(quiz_session_id, quiz_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_session_quiz_question ADD CONSTRAINT FK_C0BBC8C12850CBE3 FOREIGN KEY (quiz_session_id) REFERENCES quiz_session (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_quiz_question ADD CONSTRAINT FK_C0BBC8C13101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_level DROP FOREIGN KEY FK_6B2EA6D42850CBE3');
        $this->addSql('ALTER TABLE quiz_session_level DROP FOREIGN KEY FK_6B2EA6D4A0F35D66');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question DROP FOREIGN KEY FK_43B3F3E4C84A4E17');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question DROP FOREIGN KEY FK_43B3F3E43101E51F');
        $this->addSql('DROP TABLE quiz_session_level');
        $this->addSql('DROP TABLE quiz_session_level_quiz_question');
        $this->addSql('DROP INDEX UNIQ_C21E7874C2C9318D ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session CHANGE current_level_id current_question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E7874A0F35D66 FOREIGN KEY (current_question_id) REFERENCES quiz_question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C21E7874A0F35D66 ON quiz_session (current_question_id)');
    }
}
