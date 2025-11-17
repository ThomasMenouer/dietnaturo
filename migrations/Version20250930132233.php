<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250930132233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ateliers ADD places INT DEFAULT 5 NOT NULL, CHANGE is_available is_available TINYINT(1) DEFAULT 0 NOT NULL, CHANGE is_visio is_visio TINYINT(1) DEFAULT 0 NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ateliers DROP places, CHANGE is_available is_available TINYINT(1) NOT NULL, CHANGE is_visio is_visio TINYINT(1) NOT NULL
        SQL);
    }
}
