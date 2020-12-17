<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217135302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Scheduled tasks';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, task_name VARCHAR(255) NOT NULL, queue_name VARCHAR(80) NOT NULL, scheduled_at DATETIME NOT NULL, executed_at DATETIME DEFAULT NULL, description VARCHAR(255) NOT NULL, context JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE schedule');
    }
}
