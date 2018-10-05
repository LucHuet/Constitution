<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181005101141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD pouvoir_partie_id INT NOT NULL');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7C49D3C5A8 FOREIGN KEY (pouvoir_partie_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('CREATE INDEX IDX_B3255A7C49D3C5A8 ON condition_pouvoir_partie (pouvoir_partie_id)');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B472923B7A385E');
        $this->addSql('DROP INDEX UNIQ_E7B472923B7A385E ON pouvoir_partie');
        $this->addSql('ALTER TABLE pouvoir_partie DROP condition_pouvoir_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP FOREIGN KEY FK_B3255A7C49D3C5A8');
        $this->addSql('DROP INDEX IDX_B3255A7C49D3C5A8 ON condition_pouvoir_partie');
        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP pouvoir_partie_id');
        $this->addSql('ALTER TABLE pouvoir_partie ADD condition_pouvoir_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B472923B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir_partie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E7B472923B7A385E ON pouvoir_partie (condition_pouvoir_id)');
    }
}
