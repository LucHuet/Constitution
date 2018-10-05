<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181002125740 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE designation_partie ADD partie_id INT NOT NULL');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_24553869E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('CREATE INDEX IDX_24553869E075F7A4 ON designation_partie (partie_id)');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD partie_id INT NOT NULL');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7CE075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('CREATE INDEX IDX_B3255A7CE075F7A4 ON condition_pouvoir_partie (partie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP FOREIGN KEY FK_B3255A7CE075F7A4');
        $this->addSql('DROP INDEX IDX_B3255A7CE075F7A4 ON condition_pouvoir_partie');
        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP partie_id');
        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_24553869E075F7A4');
        $this->addSql('DROP INDEX IDX_24553869E075F7A4 ON designation_partie');
        $this->addSql('ALTER TABLE designation_partie DROP partie_id');
    }
}
