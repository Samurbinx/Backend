<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241118094940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_artwork (id INT AUTO_INCREMENT NOT NULL, cart_id INT NOT NULL, artwork_id INT NOT NULL, selected TINYINT(1) NOT NULL, INDEX IDX_73C50D711AD5CDBF (cart_id), INDEX IDX_73C50D71DB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_artwork ADD CONSTRAINT FK_73C50D711AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_artwork ADD CONSTRAINT FK_73C50D71DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart_artwork DROP FOREIGN KEY FK_73C50D711AD5CDBF');
        $this->addSql('ALTER TABLE cart_artwork DROP FOREIGN KEY FK_73C50D71DB8FFA4');
        $this->addSql('DROP TABLE cart_artwork');
    }
}
