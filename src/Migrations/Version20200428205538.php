<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200428205538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_item_actions DROP FOREIGN KEY FK_A75AEE8FAB0EE04A');
        $this->addSql('DROP INDEX IDX_A75AEE8FAB0EE04A ON amazon_item_actions');
        $this->addSql('ALTER TABLE amazon_item_actions CHANGE feed_submission_id_id feed_submission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE amazon_item_actions ADD CONSTRAINT FK_A75AEE8F1DAB00D1 FOREIGN KEY (feed_submission_id) REFERENCES amazon_feed_submission (id)');
        $this->addSql('CREATE INDEX IDX_A75AEE8F1DAB00D1 ON amazon_item_actions (feed_submission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amazon_item_actions DROP FOREIGN KEY FK_A75AEE8F1DAB00D1');
        $this->addSql('DROP INDEX IDX_A75AEE8F1DAB00D1 ON amazon_item_actions');
        $this->addSql('ALTER TABLE amazon_item_actions CHANGE feed_submission_id feed_submission_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE amazon_item_actions ADD CONSTRAINT FK_A75AEE8FAB0EE04A FOREIGN KEY (feed_submission_id_id) REFERENCES amazon_feed_submission (id)');
        $this->addSql('CREATE INDEX IDX_A75AEE8FAB0EE04A ON amazon_item_actions (feed_submission_id_id)');
    }
}
