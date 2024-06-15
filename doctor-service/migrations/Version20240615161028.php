<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240615161028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add customer_id to doctor_profile table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE doctor_profile ADD customer_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE doctor_profile DROP customer_id');
    }
}
