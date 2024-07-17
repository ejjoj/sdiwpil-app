<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715100713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE appointment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appointment (
          id INT NOT NULL,
          patient_profile_id INT NOT NULL,
          doctor_profile_id INT NOT NULL,
          scheduled_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          patient_reason_for_appointment TEXT NOT NULL,
          doctor_notes TEXT DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('COMMENT ON COLUMN appointment.scheduled_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appointment_id_seq CASCADE');
        $this->addSql('DROP TABLE appointment');
    }
}
