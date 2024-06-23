<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240623102322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Customer ID unique.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_12FAC9A29395C3F3 ON doctor_profile (customer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_12FAC9A29395C3F3');
    }
}
