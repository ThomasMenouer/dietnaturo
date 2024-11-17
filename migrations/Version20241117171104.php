<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241117171104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ateliers ADD date DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_716970924AE1BA34 ON participants');
        $this->addSql('ALTER TABLE participants DROP date_disponible_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ateliers DROP date');
        $this->addSql('ALTER TABLE participants ADD date_disponible_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_716970924AE1BA34 ON participants (date_disponible_id)');
    }
}
