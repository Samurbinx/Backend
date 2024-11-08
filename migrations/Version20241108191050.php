<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241108191050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_D012DB7CA76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_D012DB7CDB8FFA4');
        $this->addSql('DROP INDEX idx_d012db7ca76ed395 ON favorites');
        $this->addSql('CREATE INDEX IDX_E46960F5A76ED395 ON favorites (user_id)');
        $this->addSql('DROP INDEX idx_d012db7cdb8ffa4 ON favorites');
        $this->addSql('CREATE INDEX IDX_E46960F5DB8FFA4 ON favorites (artwork_id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_D012DB7CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_D012DB7CDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5A76ED395');
        $this->addSql('ALTER TABLE favorites DROP FOREIGN KEY FK_E46960F5DB8FFA4');
        $this->addSql('DROP INDEX idx_e46960f5db8ffa4 ON favorites');
        $this->addSql('CREATE INDEX IDX_D012DB7CDB8FFA4 ON favorites (artwork_id)');
        $this->addSql('DROP INDEX idx_e46960f5a76ed395 ON favorites');
        $this->addSql('CREATE INDEX IDX_D012DB7CA76ED395 ON favorites (user_id)');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_E46960F5DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE');
    }
}
