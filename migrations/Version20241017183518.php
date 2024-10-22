<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017183518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, work_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, creation_date DATE DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, sold TINYINT(1) NOT NULL, display VARCHAR(255) DEFAULT NULL, INDEX IDX_881FC576BB3453DB (work_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, subtitle VARCHAR(5000) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, artwork_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, creation_date DATE DEFAULT NULL, materials VARCHAR(255) DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, depht DOUBLE PRECISION DEFAULT NULL, images JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', price DOUBLE PRECISION DEFAULT NULL, sold TINYINT(1) NOT NULL, display VARCHAR(255) NOT NULL, INDEX IDX_44CA0B23DB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, nick VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, statement VARCHAR(5000) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B23DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576BB3453DB');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B23DB8FFA4');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work');
    }
}
