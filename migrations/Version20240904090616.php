<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904090616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compensation_calculation_line (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, compensation_rule_id INT NOT NULL, work_date DATE NOT NULL, direction VARCHAR(10) NOT NULL, compensation NUMERIC(10, 2) NOT NULL, INDEX IDX_52361E7A8C03F15C (employee_id), INDEX IDX_52361E7AA33D519A (compensation_rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compensation_rule (id INT AUTO_INCREMENT NOT NULL, transport_id INT NOT NULL, name VARCHAR(255) NOT NULL, distance_from INT NOT NULL, distance_till INT DEFAULT NULL, compensation NUMERIC(10, 2) NOT NULL, INDEX IDX_710A4E629909C13F (transport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compensation_calculation_line ADD CONSTRAINT FK_52361E7A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE compensation_calculation_line ADD CONSTRAINT FK_52361E7AA33D519A FOREIGN KEY (compensation_rule_id) REFERENCES compensation_rule (id)');
        $this->addSql('ALTER TABLE compensation_rule ADD CONSTRAINT FK_710A4E629909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compensation_calculation_line DROP FOREIGN KEY FK_52361E7A8C03F15C');
        $this->addSql('ALTER TABLE compensation_calculation_line DROP FOREIGN KEY FK_52361E7AA33D519A');
        $this->addSql('ALTER TABLE compensation_rule DROP FOREIGN KEY FK_710A4E629909C13F');
        $this->addSql('DROP TABLE compensation_calculation_line');
        $this->addSql('DROP TABLE compensation_rule');
    }
}
