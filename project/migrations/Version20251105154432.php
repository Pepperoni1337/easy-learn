<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105154432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question DROP FOREIGN KEY FK_43B3F3E43101E51F');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question DROP FOREIGN KEY FK_43B3F3E4C84A4E17');
        $this->addSql('DROP TABLE quiz_session_level_quiz_question');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_session_level_quiz_question (quiz_session_level_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid_id)\', quiz_question_id CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:uuid_id)\', INDEX IDX_43B3F3E43101E51F (quiz_question_id), INDEX IDX_43B3F3E4C84A4E17 (quiz_session_level_id), PRIMARY KEY(quiz_session_level_id, quiz_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question ADD CONSTRAINT FK_43B3F3E43101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_session_level_quiz_question ADD CONSTRAINT FK_43B3F3E4C84A4E17 FOREIGN KEY (quiz_session_level_id) REFERENCES quiz_session_level (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
