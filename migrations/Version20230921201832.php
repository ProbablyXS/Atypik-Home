<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230921201832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability ADD hostings_id INT NOT NULL');
        $this->addSql('ALTER TABLE availability ADD CONSTRAINT FK_3FB7A2BFA7002607 FOREIGN KEY (hostings_id) REFERENCES hostings (id)');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFA7002607 ON availability (hostings_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability DROP FOREIGN KEY FK_3FB7A2BFA7002607');
        $this->addSql('DROP INDEX IDX_3FB7A2BFA7002607 ON availability');
        $this->addSql('ALTER TABLE availability DROP hostings_id');
    }
}
