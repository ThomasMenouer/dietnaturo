<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707092554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE products_cover (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_6D5178154584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE products_ebook (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, file_name VARCHAR(255) DEFAULT NULL, file_size INT DEFAULT NULL, format VARCHAR(10) NOT NULL, updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_9D088DDD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products_cover ADD CONSTRAINT FK_6D5178154584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products_ebook ADD CONSTRAINT FK_9D088DDD4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products ADD enabled TINYINT(1) NOT NULL, DROP image_name, DROP image_size, DROP updated_at
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE products_cover DROP FOREIGN KEY FK_6D5178154584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products_ebook DROP FOREIGN KEY FK_9D088DDD4584665A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE products_cover
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE products_ebook
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', DROP enabled
        SQL);
    }
}
