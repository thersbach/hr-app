<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904090810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    /** specfication:
     * At This company we encourage a healthy lifestyle, therefore we encourage our employees
     * to come to work by bike. If you would commute by bike you will get a compensation of
     * € 0,50 per km per day. For distances between 5 to 10 km the compensation will even
     * double! However, for distances over 10 km employees prefer a different way of commuting.
     * Some employees commute by bus or train, for which the compensation is € 0,25 per km per
     * day. If you would commute by car the compensation would be € 0,10 per km per day.
     */
    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO compensation_rule 
            (transport_id, name, distance_from, distance_till, compensation) 
        VALUES (2, 'Bike', 0, NULL, 0.5), 
               (2, 'Bike BONUS', 0, 10, 0.5), 
               (3, 'Public transport', 0, NULL, 0.25), 
               (1, 'Car', 0, NULL, 0.1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM compensation_rule WHERE name IN ('Bike', 'Bike BONUS', 'Public transport', 'Car')");
    }
}
