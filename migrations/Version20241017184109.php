<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017184109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece DROP creation_date, DROP price, DROP sold, DROP display');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece ADD creation_date DATE DEFAULT NULL, ADD price DOUBLE PRECISION DEFAULT NULL, ADD sold TINYINT(1) NOT NULL, ADD display VARCHAR(255) NOT NULL');
    }
}
