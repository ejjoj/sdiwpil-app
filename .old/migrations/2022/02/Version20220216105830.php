<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216105830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor_data (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_EB72CD0387F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manager_data (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_ABFA511A783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_data (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2462BEAB6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receptionist_data (id INT AUTO_INCREMENT NOT NULL, receptionist_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_D74D10ABBD690E33 (receptionist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, patient_data_id INT DEFAULT NULL, doctor_data_id INT DEFAULT NULL, receptionist_data_id INT DEFAULT NULL, manager_data_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6496A96F4D7 (patient_data_id), UNIQUE INDEX UNIQ_8D93D649A458C291 (doctor_data_id), UNIQUE INDEX UNIQ_8D93D649F1C3581A (receptionist_data_id), UNIQUE INDEX UNIQ_8D93D6498938942A (manager_data_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctor_data ADD CONSTRAINT FK_EB72CD0387F4FB17 FOREIGN KEY (doctor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE manager_data ADD CONSTRAINT FK_ABFA511A783E3463 FOREIGN KEY (manager_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE patient_data ADD CONSTRAINT FK_2462BEAB6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE receptionist_data ADD CONSTRAINT FK_D74D10ABBD690E33 FOREIGN KEY (receptionist_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496A96F4D7 FOREIGN KEY (patient_data_id) REFERENCES patient_data (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A458C291 FOREIGN KEY (doctor_data_id) REFERENCES doctor_data (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F1C3581A FOREIGN KEY (receptionist_data_id) REFERENCES receptionist_data (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498938942A FOREIGN KEY (manager_data_id) REFERENCES manager_data (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A458C291');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498938942A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496A96F4D7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F1C3581A');
        $this->addSql('ALTER TABLE doctor_data DROP FOREIGN KEY FK_EB72CD0387F4FB17');
        $this->addSql('ALTER TABLE manager_data DROP FOREIGN KEY FK_ABFA511A783E3463');
        $this->addSql('ALTER TABLE patient_data DROP FOREIGN KEY FK_2462BEAB6B899279');
        $this->addSql('ALTER TABLE receptionist_data DROP FOREIGN KEY FK_D74D10ABBD690E33');
        $this->addSql('DROP TABLE doctor_data');
        $this->addSql('DROP TABLE manager_data');
        $this->addSql('DROP TABLE patient_data');
        $this->addSql('DROP TABLE receptionist_data');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
