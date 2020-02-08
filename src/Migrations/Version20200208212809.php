<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208212809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amazon_feed_item_action (id INT AUTO_INCREMENT NOT NULL, feed_submission_id VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, item_action VARCHAR(255) NOT NULL, synched_to_amazon TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amazon_feed_submission MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE amazon_feed_submission DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE amazon_feed_submission DROP id');
        $this->addSql('ALTER TABLE amazon_feed_submission ADD PRIMARY KEY (feed_submission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amazon_feed_item_action');
        $this->addSql('ALTER TABLE amazon_feed_submission ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
