<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208213326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amazon_feed_item_action_amazon_feed_submission (amazon_feed_item_action_id INT NOT NULL, amazon_feed_submission_id INT NOT NULL, INDEX IDX_A55B210B4A897DEB (amazon_feed_item_action_id), INDEX IDX_A55B210B3BAFB119 (amazon_feed_submission_id), PRIMARY KEY(amazon_feed_item_action_id, amazon_feed_submission_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amazon_feed_item_action_amazon_feed_submission ADD CONSTRAINT FK_A55B210B4A897DEB FOREIGN KEY (amazon_feed_item_action_id) REFERENCES amazon_feed_item_action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amazon_feed_item_action_amazon_feed_submission ADD CONSTRAINT FK_A55B210B3BAFB119 FOREIGN KEY (amazon_feed_submission_id) REFERENCES amazon_feed_submission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amazon_feed_submission ADD id INT NOT NULL, CHANGE feed_submission_id feed_submission_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amazon_feed_item_action DROP feed_submission_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amazon_feed_item_action_amazon_feed_submission');
        $this->addSql('ALTER TABLE amazon_feed_item_action ADD feed_submission_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE amazon_feed_submission DROP id, CHANGE feed_submission_id feed_submission_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
