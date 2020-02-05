<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204170349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amazon_item_actions (id INT AUTO_INCREMENT NOT NULL, amazon_action VARCHAR(255) NOT NULL, ean VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, uvp DOUBLE PRECISION NOT NULL, on_stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amazon_artikelstamm (article_id INT NOT NULL, battery_enthalten TINYINT(1) NOT NULL, article_category VARCHAR(255) DEFAULT NULL, shop_category VARCHAR(255) DEFAULT NULL, delivery_time VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_html LONGTEXT NOT NULL, marke VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, image_1 VARCHAR(255) NOT NULL, image_2 VARCHAR(255) DEFAULT NULL, image_3 VARCHAR(255) DEFAULT NULL, image_4 VARCHAR(255) DEFAULT NULL, image_5 VARCHAR(255) DEFAULT NULL, image_6 VARCHAR(255) DEFAULT NULL, image_7 VARCHAR(255) DEFAULT NULL, image_8 VARCHAR(255) DEFAULT NULL, image_9 VARCHAR(255) DEFAULT NULL, image_10 VARCHAR(255) DEFAULT NULL, length VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keyword TINYTEXT DEFAULT NULL, shipping_cost VARCHAR(255) DEFAULT NULL, shop_url VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, brand VARCHAR(255) NOT NULL, ean VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, uvp DOUBLE PRECISION NOT NULL, on_stock INT NOT NULL, PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wenko_artikelstamm DROP market_place, CHANGE quantity on_stock INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amazon_item_actions');
        $this->addSql('DROP TABLE amazon_artikelstamm');
        $this->addSql('ALTER TABLE wenko_artikelstamm ADD market_place VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE on_stock quantity INT NOT NULL');
    }
}
