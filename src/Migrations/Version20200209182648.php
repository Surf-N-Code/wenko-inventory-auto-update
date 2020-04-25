<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209182648 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amazon_item_actions_amazon_feed_submission (amazon_item_actions_id INT NOT NULL, amazon_feed_submission_id INT NOT NULL, INDEX IDX_62FC9FE0C76BFFA2 (amazon_item_actions_id), INDEX IDX_62FC9FE03BAFB119 (amazon_feed_submission_id), PRIMARY KEY(amazon_item_actions_id, amazon_feed_submission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amazon_item_actions_amazon_feed_submission ADD CONSTRAINT FK_62FC9FE0C76BFFA2 FOREIGN KEY (amazon_item_actions_id) REFERENCES amazon_item_actions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amazon_item_actions_amazon_feed_submission ADD CONSTRAINT FK_62FC9FE03BAFB119 FOREIGN KEY (amazon_feed_submission_id) REFERENCES amazon_feed_submission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amazon_item_actions DROP amazon_feed_submission_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amazon_item_actions_amazon_feed_submission');
        $this->addSql('ALTER TABLE amazon_item_actions ADD amazon_feed_submission_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
