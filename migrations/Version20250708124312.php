<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250708124312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE invoices (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, invoice_number VARCHAR(255) NOT NULL, issued_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', pdf_path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6A2F2F952DA68207 (invoice_number), UNIQUE INDEX UNIQ_6A2F2F958D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices ADD CONSTRAINT FK_6A2F2F958D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE invoices DROP FOREIGN KEY FK_6A2F2F958D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE invoices
        SQL);
    }
}
