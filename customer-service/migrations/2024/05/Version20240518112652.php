<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518112652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration will update the User entity to use the new UserInterface and PasswordAuthenticatedUserInterface interfaces.';
    }

    public function up(Schema $schema): void
    {
        $upContents = file_get_contents(__DIR__ . '/20240518112652/up.sql');
        $statements = explode(sprintf(';%s', PHP_EOL), $upContents);
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->addSql($statement);
            }
        }
    }

    public function down(Schema $schema): void
    {
        $downContents = file_get_contents(__DIR__ . '/20240518112652/down.sql');
        $statements = explode(sprintf(';%s', PHP_EOL), $downContents);
        foreach ($statements as $statement) {
            if (!empty($statement)) {
                $this->addSql($statement);
            }
        }
    }
}
