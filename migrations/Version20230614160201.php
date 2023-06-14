<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230614160201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE captain (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, dni INT NOT NULL, captain_license_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, fligths_id INT NOT NULL, number VARCHAR(255) NOT NULL, origen VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C257E60EDDEAC701 ON flight (fligths_id)');
        $this->addSql('CREATE TABLE flight_passenger (flight_id INT NOT NULL, passenger_id INT NOT NULL, PRIMARY KEY(flight_id, passenger_id))');
        $this->addSql('CREATE INDEX IDX_25F7F56F91F478C5 ON flight_passenger (flight_id)');
        $this->addSql('CREATE INDEX IDX_25F7F56F4502E565 ON flight_passenger (passenger_id)');
        $this->addSql('CREATE TABLE passenger (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, dni INT NOT NULL, seat INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE steward (id INT NOT NULL, turns_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, dni INT NOT NULL, air_crew_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69A62525730AC939 ON steward (turns_id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60EDDEAC701 FOREIGN KEY (fligths_id) REFERENCES captain (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F91F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE flight_passenger ADD CONSTRAINT FK_25F7F56F4502E565 FOREIGN KEY (passenger_id) REFERENCES passenger (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT FK_69A62525730AC939 FOREIGN KEY (turns_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60EDDEAC701');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F91F478C5');
        $this->addSql('ALTER TABLE flight_passenger DROP CONSTRAINT FK_25F7F56F4502E565');
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT FK_69A62525730AC939');
        $this->addSql('DROP TABLE captain');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE flight_passenger');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE steward');
    }
}
