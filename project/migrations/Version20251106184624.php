<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106184624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_rating (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', quiz_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid_id)\', rating INT NOT NULL, INDEX IDX_35CDD67B853CD175 (quiz_id), INDEX IDX_35CDD67BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_rating ADD CONSTRAINT FK_35CDD67B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_rating ADD CONSTRAINT FK_35CDD67BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_rating DROP FOREIGN KEY FK_35CDD67B853CD175');
        $this->addSql('ALTER TABLE quiz_rating DROP FOREIGN KEY FK_35CDD67BA76ED395');
        $this->addSql('DROP TABLE quiz_rating');
    }
}
