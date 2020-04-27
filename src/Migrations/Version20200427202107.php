<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427202107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wenko_top_sellers DROP FOREIGN KEY FK_E535D8F21777D41C');
        $this->addSql('DROP INDEX UNIQ_E535D8F21777D41C ON wenko_top_sellers');
        $this->addSql('ALTER TABLE wenko_top_sellers DROP sku_id');
        $this->addSql('ALTER TABLE items_wenko MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE items_wenko DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE items_wenko DROP id');
        $this->addSql('ALTER TABLE items_wenko ADD PRIMARY KEY (sku)');
        $this->addSql('ALTER TABLE items_other DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE items_other DROP article_id');
        $this->addSql('ALTER TABLE items_other ADD PRIMARY KEY (sku)');
        $this->addSql('ALTER TABLE amazon_item_actions DROP sku');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_item_actions ADD sku VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE items_other DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE items_other ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE items_other ADD PRIMARY KEY (article_id)');
        $this->addSql('ALTER TABLE items_wenko ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE wenko_top_sellers ADD sku_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wenko_top_sellers ADD CONSTRAINT FK_E535D8F21777D41C FOREIGN KEY (sku_id) REFERENCES items_wenko (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E535D8F21777D41C ON wenko_top_sellers (sku_id)');
    }
}
