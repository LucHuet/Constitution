<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111162544 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B472923BC9C3');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B472923E4A275C');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292B67244C5');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292B9CD216D');
        $this->addSql('DROP INDEX UNIQ_E7B47292B67244C5 ON pouvoir_partie');
        $this->addSql('DROP INDEX IDX_E7B47292B9CD216D ON pouvoir_partie');
        $this->addSql('DROP INDEX IDX_E7B472923E4A275C ON pouvoir_partie');
        $this->addSql('DROP INDEX IDX_E7B472923BC9C3 ON pouvoir_partie');
        $this->addSql('ALTER TABLE pouvoir_partie DROP pouvoir_destinataire_id, DROP pouvoir_controlled_id, DROP acteur_controlled_id, DROP designation_controlled_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pouvoir_partie ADD pouvoir_destinataire_id INT DEFAULT NULL, ADD pouvoir_controlled_id INT DEFAULT NULL, ADD acteur_controlled_id INT DEFAULT NULL, ADD designation_controlled_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B472923BC9C3 FOREIGN KEY (designation_controlled_id) REFERENCES designation_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B472923E4A275C FOREIGN KEY (acteur_controlled_id) REFERENCES acteur_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292B67244C5 FOREIGN KEY (pouvoir_destinataire_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292B9CD216D FOREIGN KEY (pouvoir_controlled_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E7B47292B67244C5 ON pouvoir_partie (pouvoir_destinataire_id)');
        $this->addSql('CREATE INDEX IDX_E7B47292B9CD216D ON pouvoir_partie (pouvoir_controlled_id)');
        $this->addSql('CREATE INDEX IDX_E7B472923E4A275C ON pouvoir_partie (acteur_controlled_id)');
        $this->addSql('CREATE INDEX IDX_E7B472923BC9C3 ON pouvoir_partie (designation_controlled_id)');
    }
}
