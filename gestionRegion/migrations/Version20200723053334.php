<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200723053334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commune (id INT AUTO_INCREMENT NOT NULL, depart_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_E2E2D1EEAE02FE4B (depart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depart (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_1B3EBB0898260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EEAE02FE4B FOREIGN KEY (depart_id) REFERENCES depart (id)');
        $this->addSql('ALTER TABLE depart ADD CONSTRAINT FK_1B3EBB0898260155 FOREIGN KEY (region_id) REFERENCES region (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commune DROP FOREIGN KEY FK_E2E2D1EEAE02FE4B');
        $this->addSql('DROP TABLE commune');
        $this->addSql('DROP TABLE depart');
    }
}
