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
        $upContents = file_get_contents(__DIR__ . '/Version20240615144840/up.sql');
        $statements = explode(sprintf(';%s', PHP_EOL), $upContents);
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->addSql($statement);
            }
        }
    }

    public function down(Schema $schema): void
    {
        $downContents = file_get_contents(__DIR__ . '/Version20240615144840/down.sql');
        $statements = explode(sprintf(';%s', PHP_EOL), $downContents);
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->addSql($statement);
            }
        }
    }
}
