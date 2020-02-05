<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205175607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE items_amazon (id INT AUTO_INCREMENT NOT NULL, ean VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, uvp DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items_other (article_id INT NOT NULL, battery_enthalten TINYINT(1) NOT NULL, article_category VARCHAR(255) DEFAULT NULL, shop_category VARCHAR(255) DEFAULT NULL, delivery_time VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_html LONGTEXT NOT NULL, marke VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, image_1 VARCHAR(255) NOT NULL, image_2 VARCHAR(255) DEFAULT NULL, image_3 VARCHAR(255) DEFAULT NULL, image_4 VARCHAR(255) DEFAULT NULL, image_5 VARCHAR(255) DEFAULT NULL, image_6 VARCHAR(255) DEFAULT NULL, image_7 VARCHAR(255) DEFAULT NULL, image_8 VARCHAR(255) DEFAULT NULL, image_9 VARCHAR(255) DEFAULT NULL, image_10 VARCHAR(255) DEFAULT NULL, length VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keyword TINYTEXT DEFAULT NULL, shipping_cost VARCHAR(255) DEFAULT NULL, shop_url VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, brand VARCHAR(255) NOT NULL, ean VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, uvp DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items_wenko (article_id INT NOT NULL, battery_enthalten TINYINT(1) NOT NULL, article_category VARCHAR(255) DEFAULT NULL, shop_category VARCHAR(255) DEFAULT NULL, delivery_time VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, description_html LONGTEXT NOT NULL, marke VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, image_1 VARCHAR(255) NOT NULL, image_2 VARCHAR(255) DEFAULT NULL, image_3 VARCHAR(255) DEFAULT NULL, image_4 VARCHAR(255) DEFAULT NULL, image_5 VARCHAR(255) DEFAULT NULL, image_6 VARCHAR(255) DEFAULT NULL, image_7 VARCHAR(255) DEFAULT NULL, image_8 VARCHAR(255) DEFAULT NULL, image_9 VARCHAR(255) DEFAULT NULL, image_10 VARCHAR(255) DEFAULT NULL, length VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, meta_keyword TINYTEXT DEFAULT NULL, shipping_cost VARCHAR(255) DEFAULT NULL, shop_url VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, cost DOUBLE PRECISION DEFAULT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, brand VARCHAR(255) NOT NULL, ean VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, uvp DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE artikelstamm_amazon');
        $this->addSql('DROP TABLE artikelstamm_wenko');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE artikelstamm_amazon (id INT AUTO_INCREMENT NOT NULL, ean VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, uvp DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE artikelstamm_wenko (article_id INT NOT NULL, battery_enthalten TINYINT(1) NOT NULL, article_category VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, shop_category VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, delivery_time VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description_html LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, marke VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, height VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_1 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_2 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_3 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_4 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_5 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_6 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_7 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_8 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_9 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image_10 VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, length VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, meta_description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, meta_keyword TINYTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, shipping_cost VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, shop_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, weight VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cost DOUBLE PRECISION DEFAULT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, brand VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ean VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, uvp DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE items_amazon');
        $this->addSql('DROP TABLE items_other');
        $this->addSql('DROP TABLE items_wenko');
    }
}
