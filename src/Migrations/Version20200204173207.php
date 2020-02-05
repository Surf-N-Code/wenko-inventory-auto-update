<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204173207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artikelstamm_amazon ADD id INT AUTO_INCREMENT NOT NULL, DROP article_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE artikelstamm_amazon MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE artikelstamm_amazon DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE artikelstamm_amazon ADD article_id INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE artikelstamm_amazon ADD PRIMARY KEY (article_id)');
    }
}
