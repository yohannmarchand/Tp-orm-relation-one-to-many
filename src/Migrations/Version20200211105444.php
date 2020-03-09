<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211105444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE illustration CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(250) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD illustration_id INT DEFAULT NULL, CHANGE update_at update_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D5926566C FOREIGN KEY (illustration_id) REFERENCES illustration (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D5926566C ON post (illustration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE illustration CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(250) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D5926566C');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D5926566C ON post');
        $this->addSql('ALTER TABLE post DROP illustration_id, CHANGE update_at update_at DATETIME DEFAULT \'NULL\'');
    }
}
