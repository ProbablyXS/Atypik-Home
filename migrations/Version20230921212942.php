<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921212942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE unavailability (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hostings ADD unavailability_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hostings ADD CONSTRAINT FK_7DE1E24EF6922FEF FOREIGN KEY (unavailability_id) REFERENCES unavailability (id)');
        $this->addSql('CREATE INDEX IDX_7DE1E24EF6922FEF ON hostings (unavailability_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hostings DROP FOREIGN KEY FK_7DE1E24EF6922FEF');
        $this->addSql('DROP TABLE unavailability');
        $this->addSql('DROP INDEX IDX_7DE1E24EF6922FEF ON hostings');
        $this->addSql('ALTER TABLE hostings DROP unavailability_id');
    }
}
