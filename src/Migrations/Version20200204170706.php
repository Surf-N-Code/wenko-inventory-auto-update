<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204170706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_item_actions CHANGE on_stock stock INT NOT NULL');
        $this->addSql('ALTER TABLE artikelstamm_wenko CHANGE on_stock stock INT NOT NULL');
        $this->addSql('ALTER TABLE artikelstamm_amazon CHANGE on_stock stock INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_item_actions CHANGE stock on_stock INT NOT NULL');
        $this->addSql('ALTER TABLE artikelstamm_amazon CHANGE stock on_stock INT NOT NULL');
        $this->addSql('ALTER TABLE artikelstamm_wenko CHANGE stock on_stock INT NOT NULL');
    }
}
