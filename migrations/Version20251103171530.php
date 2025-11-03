<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251103171530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instagram_post CHANGE media_url media_url LONGTEXT NOT NULL, CHANGE permalink permalink LONGTEXT NOT NULL, CHANGE thumbnail_url thumbnail_url LONGTEXT DEFAULT NULL, CHANGE category category VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_instagram_id ON instagram_post (instagram_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_instagram_id ON instagram_post');
        $this->addSql('ALTER TABLE instagram_post CHANGE media_url media_url VARCHAR(255) NOT NULL, CHANGE permalink permalink VARCHAR(255) NOT NULL, CHANGE thumbnail_url thumbnail_url VARCHAR(255) DEFAULT NULL, CHANGE category category VARCHAR(255) NOT NULL');
    }
}
