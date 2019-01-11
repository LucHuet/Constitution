<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111142454 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_reference (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, explication VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_partie (id INT AUTO_INCREMENT NOT NULL, event_reference_id INT NOT NULL, partie_id INT NOT NULL, resultat INT NOT NULL, explication_resultat VARCHAR(255) NOT NULL, INDEX IDX_3702686FFB56D45A (event_reference_id), INDEX IDX_3702686FE075F7A4 (partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_partie ADD CONSTRAINT FK_3702686FFB56D45A FOREIGN KEY (event_reference_id) REFERENCES event_reference (id)');
        $this->addSql('ALTER TABLE event_partie ADD CONSTRAINT FK_3702686FE075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_partie DROP FOREIGN KEY FK_3702686FFB56D45A');
        $this->addSql('DROP TABLE event_reference');
        $this->addSql('DROP TABLE event_partie');
    }
}
