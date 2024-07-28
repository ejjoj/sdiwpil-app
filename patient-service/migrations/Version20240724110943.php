<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240724110943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add customer_id to patient_profile';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE patient_profile ADD customer_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DC34FFE49395C3F3 ON patient_profile (customer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_DC34FFE49395C3F3');
        $this->addSql('ALTER TABLE patient_profile DROP customer_id');
    }
}
