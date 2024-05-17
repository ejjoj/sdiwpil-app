<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412165620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD prescription_id INT DEFAULT NULL, DROP name, DROP content');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7693DB413D FOREIGN KEY (prescription_id) REFERENCES prescription (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8698A7693DB413D ON document (prescription_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7693DB413D');
        $this->addSql('DROP INDEX UNIQ_D8698A7693DB413D ON document');
        $this->addSql('ALTER TABLE document ADD name VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD content LONGBLOB NOT NULL, DROP prescription_id, CHANGE type type VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
