<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251108213941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accompagnement_content (id INT AUTO_INCREMENT NOT NULL, accompagnement_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', position INT NOT NULL, INDEX IDX_3DB1EC338E768805 (accompagnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accompagnement_content ADD CONSTRAINT FK_3DB1EC338E768805 FOREIGN KEY (accompagnement_id) REFERENCES accompagnement (id)');
        $this->addSql('DROP INDEX UNIQ_2130A05B989D9B62 ON accompagnement');
        $this->addSql('ALTER TABLE accompagnement ADD intro LONGTEXT DEFAULT NULL, DROP slug, DROP content, DROP meta_description, DROP is_published');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accompagnement_content DROP FOREIGN KEY FK_3DB1EC338E768805');
        $this->addSql('DROP TABLE accompagnement_content');
        $this->addSql('ALTER TABLE accompagnement ADD slug VARCHAR(255) NOT NULL, ADD content LONGTEXT NOT NULL, ADD meta_description VARCHAR(255) DEFAULT NULL, ADD is_published TINYINT(1) NOT NULL, DROP intro');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2130A05B989D9B62 ON accompagnement (slug)');
    }
}
