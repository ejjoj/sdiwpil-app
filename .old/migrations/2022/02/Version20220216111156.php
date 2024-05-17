<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216111156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(75) NOT NULL, country VARCHAR(90) NOT NULL, city VARCHAR(189) NOT NULL, email VARCHAR(255) NOT NULL, zip_code VARCHAR(18) NOT NULL, street_address VARCHAR(95) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clinic_doctor_data (clinic_id INT NOT NULL, doctor_data_id INT NOT NULL, INDEX IDX_98744484CC22AD4 (clinic_id), INDEX IDX_98744484A458C291 (doctor_data_id), PRIMARY KEY(clinic_id, doctor_data_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic_doctor_data ADD CONSTRAINT FK_98744484CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE clinic_doctor_data ADD CONSTRAINT FK_98744484A458C291 FOREIGN KEY (doctor_data_id) REFERENCES doctor_data (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_data ADD clinic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor_data ADD CONSTRAINT FK_EB72CD03CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('CREATE INDEX IDX_EB72CD03CC22AD4 ON doctor_data (clinic_id)');
        $this->addSql('ALTER TABLE manager_data ADD clinic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manager_data ADD CONSTRAINT FK_ABFA511ACC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('CREATE INDEX IDX_ABFA511ACC22AD4 ON manager_data (clinic_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clinic_doctor_data DROP FOREIGN KEY FK_98744484CC22AD4');
        $this->addSql('ALTER TABLE doctor_data DROP FOREIGN KEY FK_EB72CD03CC22AD4');
        $this->addSql('ALTER TABLE manager_data DROP FOREIGN KEY FK_ABFA511ACC22AD4');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE clinic_doctor_data');
        $this->addSql('DROP INDEX IDX_EB72CD03CC22AD4 ON doctor_data');
        $this->addSql('ALTER TABLE doctor_data DROP clinic_id');
        $this->addSql('DROP INDEX IDX_ABFA511ACC22AD4 ON manager_data');
        $this->addSql('ALTER TABLE manager_data DROP clinic_id');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
