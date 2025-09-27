<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926200010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Edit quiz entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz ADD title VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz DROP title, DROP description');
    }
}
