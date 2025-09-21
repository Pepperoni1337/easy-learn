<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250921114122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE quiz (id CHAR(36) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question (id CHAR(36) NOT NULL, quiz_id CHAR(36) DEFAULT NULL, question VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, INDEX IDX_6033B00B853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_session (id CHAR(36) NOT NULL, quiz_id CHAR(36) DEFAULT NULL, owner_id CHAR(36) DEFAULT NULL, current_question_id CHAR(36) DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_C21E7874853CD175 (quiz_id), INDEX IDX_C21E78747E3C61F9 (owner_id), INDEX IDX_C21E7874A0F35D66 (current_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_session_quiz_question (quiz_session_id CHAR(36) NOT NULL, quiz_question_id CHAR(36) NOT NULL, INDEX IDX_C0BBC8C12850CBE3 (quiz_session_id), INDEX IDX_C0BBC8C13101E51F (quiz_question_id), PRIMARY KEY(quiz_session_id, quiz_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E7874853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E78747E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E7874A0F35D66 FOREIGN KEY (current_question_id) REFERENCES quiz_question (id)');
        $this->addSql('ALTER TABLE quiz_session_quiz_question ADD CONSTRAINT FK_C0BBC8C12850CBE3 FOREIGN KEY (quiz_session_id) REFERENCES quiz_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_quiz_question ADD CONSTRAINT FK_C0BBC8C13101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00B853CD175');
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E7874853CD175');
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E78747E3C61F9');
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E7874A0F35D66');
        $this->addSql('ALTER TABLE quiz_session_quiz_question DROP FOREIGN KEY FK_C0BBC8C12850CBE3');
        $this->addSql('ALTER TABLE quiz_session_quiz_question DROP FOREIGN KEY FK_C0BBC8C13101E51F');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE quiz_session');
        $this->addSql('DROP TABLE quiz_session_quiz_question');
        $this->addSql('DROP TABLE user');
    }
}
