<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219092433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manager_data CHANGE clinic_id clinic_id INT NOT NULL');
        $this->addSql('ALTER TABLE receptionist_data ADD clinic_id INT NOT NULL');
        $this->addSql('ALTER TABLE receptionist_data ADD CONSTRAINT FK_D74D10ABCC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('CREATE INDEX IDX_D74D10ABCC22AD4 ON receptionist_data (clinic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment CHANGE patient_reason patient_reason VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE doctor_notes doctor_notes VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE clinic CHANGE name name VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(90) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(189) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE zip_code zip_code VARCHAR(18) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE street_address street_address VARCHAR(95) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE conversation CHANGE title title VARCHAR(40) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE channel_id channel_id VARCHAR(32) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document CHANGE name name VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(12) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE manager_data CHANGE clinic_id clinic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medical_specialty CHANGE title title VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message CHANGE content content LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient_data CHANGE pesel pesel VARCHAR(11) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender VARCHAR(6) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE receptionist_data DROP FOREIGN KEY FK_D74D10ABCC22AD4');
        $this->addSql('DROP INDEX IDX_D74D10ABCC22AD4 ON receptionist_data');
        $this->addSql('ALTER TABLE receptionist_data DROP clinic_id');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE second_name second_name VARCHAR(50) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
