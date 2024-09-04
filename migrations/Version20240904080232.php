<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904080232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    /** specs:
     * Employee 	Transport 	Distance (km/one way) 	Workdays per week
     * Paul 		Car 		60 			5
     * Martin 		Bus 		8 			4
     * Jeroen 		Bike 		9 			5
     * Tineke 		Bike 		4 			3
     * Arnout 		Train 		23 			5
     * Matthijs 	Bike 		11 			4,5
     * Rens 		Car 		12 			5
    */
    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO 
                employee
                (name, workdays, distance_from_home, transport_id) 
            VALUES 
                ('Paul', 5, 60, 1), 
                ('Martin', 4, 8, 3), 
                ('Jeroen', 5, 9, 2), 
                ('Tineke', 3, 4, 2), 
                ('Arnout', 5, 23, 3), 
                ('Matthijs', 4.5, 11, 2), 
                ('Rens', 5, 12, 1)");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM employee WHERE name IN ('Paul', 'Martin', 'Jeroen', 'Tineke', 'Arnout', 'Matthijs', 'Rens')");
    }
}
