<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502172730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_feed_submission ADD finished_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE amazon_item_actions ADD CONSTRAINT FK_A75AEE8F3BAFB119 FOREIGN KEY (amazon_feed_submission_id) REFERENCES amazon_feed_submission (id)');
        $this->addSql('CREATE INDEX IDX_A75AEE8F3BAFB119 ON amazon_item_actions (amazon_feed_submission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_feed_submission DROP finished_at');
        $this->addSql('ALTER TABLE amazon_item_actions DROP FOREIGN KEY FK_A75AEE8F3BAFB119');
        $this->addSql('DROP INDEX IDX_A75AEE8F3BAFB119 ON amazon_item_actions');
    }
}
