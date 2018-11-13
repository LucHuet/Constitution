<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113170424 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE acteur_partie DROP stabilite, DROP equilibre, DROP democratie, DROP force_acteur');
        $this->addSql('ALTER TABLE condition_pouvoir DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE designation_partie DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE pouvoir_partie DROP importance, DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE acteur DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE partie DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE pouvoir DROP importance, DROP stabilite, DROP equilibre, DROP democratie');
        $this->addSql('ALTER TABLE designation DROP stabilite, DROP equilibre, DROP democratie');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE acteur ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE acteur_partie ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL, ADD force_acteur INT NOT NULL');
        $this->addSql('ALTER TABLE condition_pouvoir ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE designation ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE designation_partie ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE partie ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE pouvoir ADD importance INT NOT NULL, ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
        $this->addSql('ALTER TABLE pouvoir_partie ADD importance INT NOT NULL, ADD stabilite INT NOT NULL, ADD equilibre INT NOT NULL, ADD democratie INT NOT NULL');
    }
}
