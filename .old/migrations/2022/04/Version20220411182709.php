<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220411182709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, document_id INT DEFAULT NULL, barcode VARCHAR(44) NOT NULL, prefix_id VARCHAR(38) NOT NULL, access_code VARCHAR(4) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', prescription_file_id VARCHAR(22) NOT NULL, medicament_name VARCHAR(255) NOT NULL, medicament_description VARCHAR(255) NOT NULL, medicament_usage_description VARCHAR(255) NOT NULL, medicament_remission VARCHAR(4) NOT NULL, UNIQUE INDEX UNIQ_1FBFB8D9C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D9C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prescription');
    }
}
