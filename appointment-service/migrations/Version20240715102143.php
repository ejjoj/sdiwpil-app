<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240715102143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add indexes to appointment table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE INDEX idx_patient_profile_id ON appointment (patient_profile_id)');
        $this->addSql('CREATE INDEX idx_doctor_profile_id ON appointment (doctor_profile_id)');
        $this->addSql('CREATE INDEX idx_scheduled_at ON appointment (scheduled_at)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX idx_patient_profile_id');
        $this->addSql('DROP INDEX idx_doctor_profile_id');
        $this->addSql('DROP INDEX idx_scheduled_at');
    }
}
