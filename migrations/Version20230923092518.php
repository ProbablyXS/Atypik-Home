<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230923092518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unavailability ADD hostings_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unavailability ADD CONSTRAINT FK_F0016D1A7002607 FOREIGN KEY (hostings_id) REFERENCES hostings (id)');
        $this->addSql('CREATE INDEX IDX_F0016D1A7002607 ON unavailability (hostings_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unavailability DROP FOREIGN KEY FK_F0016D1A7002607');
        $this->addSql('DROP INDEX IDX_F0016D1A7002607 ON unavailability');
        $this->addSql('ALTER TABLE unavailability DROP hostings_id');
    }
}
