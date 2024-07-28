<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240724094102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create patient_profile table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE patient_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE patient_profile (
          id INT NOT NULL,
          name VARCHAR(128) NOT NULL,
          second_name VARCHAR(128) DEFAULT NULL,
          surname VARCHAR(128) NOT NULL,
          pesel VARCHAR(11) NOT NULL,
          gender SMALLINT NOT NULL,
          born_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC34FFE43931747B ON patient_profile (pesel)');
        $this->addSql('COMMENT ON COLUMN patient_profile.born_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN patient_profile.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN patient_profile.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE patient_profile_id_seq CASCADE');
        $this->addSql('DROP TABLE patient_profile');
    }
}
