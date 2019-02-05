<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205151057 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE controle_partie (id INT AUTO_INCREMENT NOT NULL, pouvoir_partie_id INT NOT NULL, INDEX IDX_48BA34A749D3C5A8 (pouvoir_partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE controle_partie_acteur_partie (controle_partie_id INT NOT NULL, acteur_partie_id INT NOT NULL, INDEX IDX_7E7591112AE827F8 (controle_partie_id), INDEX IDX_7E7591119C0A0ED3 (acteur_partie_id), PRIMARY KEY(controle_partie_id, acteur_partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE controle_partie ADD CONSTRAINT FK_48BA34A749D3C5A8 FOREIGN KEY (pouvoir_partie_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('ALTER TABLE controle_partie_acteur_partie ADD CONSTRAINT FK_7E7591112AE827F8 FOREIGN KEY (controle_partie_id) REFERENCES controle_partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE controle_partie_acteur_partie ADD CONSTRAINT FK_7E7591119C0A0ED3 FOREIGN KEY (acteur_partie_id) REFERENCES acteur_partie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE controle_partie_acteur_partie DROP FOREIGN KEY FK_7E7591112AE827F8');
        $this->addSql('DROP TABLE controle_partie');
        $this->addSql('DROP TABLE controle_partie_acteur_partie');
    }
}
