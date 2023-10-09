<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930111014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, tournament_id INT NOT NULL, begin_date_time DATETIME NOT NULL, is_handicap TINYINT(1) NOT NULL, is_open TINYINT(1) NOT NULL, min_age INT DEFAULT NULL, max_age INT DEFAULT NULL, min_points INT DEFAULT NULL, max_points INT DEFAULT NULL, only_men TINYINT(1) NOT NULL, only_women TINYINT(1) NOT NULL, min_places INT NOT NULL, max_places INT NOT NULL, price INT NOT NULL, INDEX IDX_AA3A933433D1A3E7 (tournament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933433D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A933433D1A3E7');
        $this->addSql('DROP TABLE serie');
    }
}
