<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830202218 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE designation_partie ADD condition_designation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_24553869AE56F0D1 FOREIGN KEY (condition_designation_id) REFERENCES condition_designation_partie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24553869AE56F0D1 ON designation_partie (condition_designation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_24553869AE56F0D1');
        $this->addSql('DROP INDEX UNIQ_24553869AE56F0D1 ON designation_partie');
        $this->addSql('ALTER TABLE designation_partie DROP condition_designation_id');
    }
}
