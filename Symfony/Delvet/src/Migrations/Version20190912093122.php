<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190912093122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributors CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE courses CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE contributors_id contributors_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE confirmation_token confirmation_token TINYINT(1) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contributors CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE courses CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE contributors_id contributors_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages CHANGE content content LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\', CHANGE confirmation_token confirmation_token TINYINT(1) DEFAULT \'NULL\'');
    }
}
