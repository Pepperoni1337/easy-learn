<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251102153534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E78747E3C61F9');
        $this->addSql('DROP INDEX IDX_C21E78747E3C61F9 ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session CHANGE owner_id player_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E787499E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C21E787499E6F5DF ON quiz_session (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_session DROP FOREIGN KEY FK_C21E787499E6F5DF');
        $this->addSql('DROP INDEX IDX_C21E787499E6F5DF ON quiz_session');
        $this->addSql('ALTER TABLE quiz_session CHANGE player_id owner_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid_id)\'');
        $this->addSql('ALTER TABLE quiz_session ADD CONSTRAINT FK_C21E78747E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C21E78747E3C61F9 ON quiz_session (owner_id)');
    }
}
