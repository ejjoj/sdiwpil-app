<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240615144840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration will create the DoctorProfile and MedicalSpecialisation entities.';
    }

    public function up(Schema $schema): void
    {
        $upContents = file_get_contents(__DIR__ . '/20240615144840/up.sql');
        $statements = explode(sprintf(';%s', PHP_EOL), $upContents);
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->addSql($statement);
            }
        }
    }

    public function down(Schema $schema): void
    {
        // TODO: Put in the down.sql file
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE doctor_profile_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE medical_specialisation_id_seq CASCADE');
        $this->addSql('ALTER TABLE doctor_profile DROP CONSTRAINT FK_12FAC9A26F992C8B');
        $this->addSql('DROP TABLE doctor_profile');
        $this->addSql('DROP TABLE medical_specialisation');
    }
}
