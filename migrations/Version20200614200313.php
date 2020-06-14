<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200614200313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE url ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE url ADD CONSTRAINT FK_F47645AE6BF700BD FOREIGN KEY (status_id) REFERENCES url_status (id)');
        $this->addSql('CREATE INDEX IDX_F47645AE6BF700BD ON url (status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url DROP FOREIGN KEY FK_F47645AE6BF700BD');
        $this->addSql('DROP TABLE url_status');
        $this->addSql('DROP INDEX IDX_F47645AE6BF700BD ON url');
        $this->addSql('ALTER TABLE url DROP status_id');
    }
}
