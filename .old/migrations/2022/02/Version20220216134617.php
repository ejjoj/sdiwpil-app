<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216134617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, doctor_id INT NOT NULL, title VARCHAR(40) NOT NULL, channel_id VARCHAR(32) NOT NULL, INDEX IDX_8A8E26E96B899279 (patient_id), INDEX IDX_8A8E26E987F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_specialty (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(75) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT NOT NULL, sender_id INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307F9AC0396 (conversation_id), INDEX IDX_B6BD307FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E96B899279 FOREIGN KEY (patient_id) REFERENCES patient_data (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor_data (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE doctor_data ADD medical_specialty_id INT NOT NULL');
        $this->addSql('ALTER TABLE doctor_data ADD CONSTRAINT FK_EB72CD03BFC81879 FOREIGN KEY (medical_specialty_id) REFERENCES medical_specialty (id)');
        $this->addSql('CREATE INDEX IDX_EB72CD03BFC81879 ON doctor_data (medical_specialty_id)');
        $this->addSql('ALTER TABLE patient_data ADD pesel VARCHAR(11) NOT NULL, ADD gender VARCHAR(6) NOT NULL, ADD born_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(50) NOT NULL, ADD second_name VARCHAR(50) DEFAULT NULL, ADD last_name VARCHAR(75) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE doctor_data DROP FOREIGN KEY FK_EB72CD03BFC81879');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE medical_specialty');
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE appointment CHANGE patient_reason patient_reason VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE doctor_notes doctor_notes VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE clinic CHANGE name name VARCHAR(75) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(90) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(189) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE zip_code zip_code VARCHAR(18) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE street_address street_address VARCHAR(95) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_EB72CD03BFC81879 ON doctor_data');
        $this->addSql('ALTER TABLE doctor_data DROP medical_specialty_id');
        $this->addSql('ALTER TABLE document CHANGE name name VARCHAR(80) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE type type VARCHAR(12) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient_data DROP pesel, DROP gender, DROP born_at');
        $this->addSql('ALTER TABLE user DROP first_name, DROP second_name, DROP last_name, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
