<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412160932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor_data ADD pwz_id VARCHAR(7) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB72CD036C90CC67 ON doctor_data (pwz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EB72CD036C90CC67 ON doctor_data');
        $this->addSql('ALTER TABLE doctor_data DROP pwz_id');
    }
}
