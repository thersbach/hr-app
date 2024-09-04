<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904073020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO transport (name) VALUES ('car'), ('bike'), ('public_transport')");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM transport WHERE name IN ('car', 'bike', 'public_transport')");
    }
}
