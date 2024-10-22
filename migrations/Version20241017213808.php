<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017213808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materials (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_materials (piece_id INT NOT NULL, materials_id INT NOT NULL, INDEX IDX_AB969B33C40FCFA8 (piece_id), INDEX IDX_AB969B333A9FC940 (materials_id), PRIMARY KEY(piece_id, materials_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE piece_materials ADD CONSTRAINT FK_AB969B33C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piece_materials ADD CONSTRAINT FK_AB969B333A9FC940 FOREIGN KEY (materials_id) REFERENCES materials (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piece DROP materials');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece_materials DROP FOREIGN KEY FK_AB969B33C40FCFA8');
        $this->addSql('ALTER TABLE piece_materials DROP FOREIGN KEY FK_AB969B333A9FC940');
        $this->addSql('DROP TABLE materials');
        $this->addSql('DROP TABLE piece_materials');
        $this->addSql('ALTER TABLE piece ADD materials VARCHAR(255) DEFAULT NULL');
    }
}
