<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180830201155 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE acteur_partie (id INT AUTO_INCREMENT NOT NULL, partie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, nombre_individus INT DEFAULT NULL, INDEX IDX_CF6D2253E075F7A4 (partie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_pouvoir (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_pouvoir_partie (id INT AUTO_INCREMENT NOT NULL, condition_pouvoir_id INT NOT NULL, nom VARCHAR(255) NOT NULL, parametre LONGTEXT DEFAULT NULL, INDEX IDX_B3255A7C3B7A385E (condition_pouvoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation_partie (id INT AUTO_INCREMENT NOT NULL, designation_id INT NOT NULL, acteur_destinataire_id INT NOT NULL, acteur_recepteur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_24553869FAC7D83F (designation_id), INDEX IDX_24553869994C61C5 (acteur_destinataire_id), INDEX IDX_245538696F3330DD (acteur_recepteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_designation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir_partie (id INT AUTO_INCREMENT NOT NULL, partie_id INT NOT NULL, pouvoir_id INT NOT NULL, pouvoir_destinataire_id INT DEFAULT NULL, condition_pouvoir_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_E7B47292E075F7A4 (partie_id), INDEX IDX_E7B47292C8A705F8 (pouvoir_id), UNIQUE INDEX UNIQ_E7B47292B67244C5 (pouvoir_destinataire_id), UNIQUE INDEX UNIQ_E7B472923B7A385E (condition_pouvoir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir_partie_acteur_partie (pouvoir_partie_id INT NOT NULL, acteur_partie_id INT NOT NULL, INDEX IDX_C7DC682E49D3C5A8 (pouvoir_partie_id), INDEX IDX_C7DC682E9C0A0ED3 (acteur_partie_id), PRIMARY KEY(pouvoir_partie_id, acteur_partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acteur (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_designation_partie (id INT AUTO_INCREMENT NOT NULL, condition_designation_id INT NOT NULL, duree INT DEFAULT NULL, renouvelabilite INT DEFAULT NULL, is_cumulable TINYINT(1) NOT NULL, INDEX IDX_20F7378CAE56F0D1 (condition_designation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, importance INT NOT NULL, is_controle TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE designation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acteur_partie ADD CONSTRAINT FK_CF6D2253E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('ALTER TABLE condition_pouvoir_partie ADD CONSTRAINT FK_B3255A7C3B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_24553869FAC7D83F FOREIGN KEY (designation_id) REFERENCES designation (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_24553869994C61C5 FOREIGN KEY (acteur_destinataire_id) REFERENCES acteur_partie (id)');
        $this->addSql('ALTER TABLE designation_partie ADD CONSTRAINT FK_245538696F3330DD FOREIGN KEY (acteur_recepteur_id) REFERENCES acteur_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292C8A705F8 FOREIGN KEY (pouvoir_id) REFERENCES pouvoir (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B47292B67244C5 FOREIGN KEY (pouvoir_destinataire_id) REFERENCES pouvoir_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie ADD CONSTRAINT FK_E7B472923B7A385E FOREIGN KEY (condition_pouvoir_id) REFERENCES condition_pouvoir_partie (id)');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie ADD CONSTRAINT FK_C7DC682E49D3C5A8 FOREIGN KEY (pouvoir_partie_id) REFERENCES pouvoir_partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie ADD CONSTRAINT FK_C7DC682E9C0A0ED3 FOREIGN KEY (acteur_partie_id) REFERENCES acteur_partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE condition_designation_partie ADD CONSTRAINT FK_20F7378CAE56F0D1 FOREIGN KEY (condition_designation_id) REFERENCES condition_designation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_24553869994C61C5');
        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_245538696F3330DD');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie DROP FOREIGN KEY FK_C7DC682E9C0A0ED3');
        $this->addSql('ALTER TABLE condition_pouvoir_partie DROP FOREIGN KEY FK_B3255A7C3B7A385E');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B472923B7A385E');
        $this->addSql('ALTER TABLE condition_designation_partie DROP FOREIGN KEY FK_20F7378CAE56F0D1');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292B67244C5');
        $this->addSql('ALTER TABLE pouvoir_partie_acteur_partie DROP FOREIGN KEY FK_C7DC682E49D3C5A8');
        $this->addSql('ALTER TABLE pouvoir_partie DROP FOREIGN KEY FK_E7B47292C8A705F8');
        $this->addSql('ALTER TABLE designation_partie DROP FOREIGN KEY FK_24553869FAC7D83F');
        $this->addSql('DROP TABLE acteur_partie');
        $this->addSql('DROP TABLE condition_pouvoir');
        $this->addSql('DROP TABLE condition_pouvoir_partie');
        $this->addSql('DROP TABLE designation_partie');
        $this->addSql('DROP TABLE condition_designation');
        $this->addSql('DROP TABLE pouvoir_partie');
        $this->addSql('DROP TABLE pouvoir_partie_acteur_partie');
        $this->addSql('DROP TABLE acteur');
        $this->addSql('DROP TABLE condition_designation_partie');
        $this->addSql('DROP TABLE pouvoir');
        $this->addSql('DROP TABLE designation');
    }
}
