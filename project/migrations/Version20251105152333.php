<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105152333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_session_level_question (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', level_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\', question VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, wrong_answer1 VARCHAR(255) NOT NULL, wrong_answer2 VARCHAR(255) NOT NULL, wrong_answer3 VARCHAR(255) NOT NULL, INDEX IDX_404F4F485FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_session_level_question ADD CONSTRAINT FK_404F4F485FB14BA7 FOREIGN KEY (level_id) REFERENCES quiz_session_level (id)');
        $this->addSql('ALTER TABLE quiz_question CHANGE wrong_answer1 wrong_answer1 VARCHAR(255) NOT NULL, CHANGE wrong_answer2 wrong_answer2 VARCHAR(255) NOT NULL, CHANGE wrong_answer3 wrong_answer3 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_level_question DROP FOREIGN KEY FK_404F4F485FB14BA7');
        $this->addSql('DROP TABLE quiz_session_level_question');
        $this->addSql('ALTER TABLE quiz_question CHANGE wrong_answer1 wrong_answer1 VARCHAR(255) DEFAULT NULL, CHANGE wrong_answer2 wrong_answer2 VARCHAR(255) DEFAULT NULL, CHANGE wrong_answer3 wrong_answer3 VARCHAR(255) DEFAULT NULL');
    }
}
