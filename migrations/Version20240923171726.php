<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240923171726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dates_ateliers DROP FOREIGN KEY FK_FD5F90EB82E2CF35');
        $this->addSql('DROP INDEX IDX_FD5F90EB82E2CF35 ON dates_ateliers');
        $this->addSql('ALTER TABLE dates_ateliers CHANGE atelier_id ateliers_id INT NOT NULL');
        $this->addSql('ALTER TABLE dates_ateliers ADD CONSTRAINT FK_FD5F90EBB1409BC9 FOREIGN KEY (ateliers_id) REFERENCES ateliers (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_FD5F90EBB1409BC9 ON dates_ateliers (ateliers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dates_ateliers DROP FOREIGN KEY FK_FD5F90EBB1409BC9');
        $this->addSql('DROP INDEX IDX_FD5F90EBB1409BC9 ON dates_ateliers');
        $this->addSql('ALTER TABLE dates_ateliers CHANGE ateliers_id atelier_id INT NOT NULL');
        $this->addSql('ALTER TABLE dates_ateliers ADD CONSTRAINT FK_FD5F90EB82E2CF35 FOREIGN KEY (atelier_id) REFERENCES ateliers (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_FD5F90EB82E2CF35 ON dates_ateliers (atelier_id)');
    }
}
