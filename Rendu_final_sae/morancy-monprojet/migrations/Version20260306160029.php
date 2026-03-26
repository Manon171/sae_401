<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306160029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE code_region (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE departement DROP nom, CHANGE code code_region VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6370E4A9D4 FOREIGN KEY (code_region) REFERENCES region (code)');
        $this->addSql('CREATE INDEX IDX_C1765B6370E4A9D4 ON departement (code_region)');
        $this->addSql('ALTER TABLE region ADD dataviz VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE code_region');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6370E4A9D4');
        $this->addSql('DROP INDEX IDX_C1765B6370E4A9D4 ON departement');
        $this->addSql('ALTER TABLE departement ADD nom VARCHAR(255) DEFAULT NULL, CHANGE code_region code VARCHAR(3) DEFAULT NULL');
        $this->addSql('ALTER TABLE region DROP dataviz');
    }
}
